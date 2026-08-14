<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Rezervasyon listesini gösterir. Durum ve tarih aralığına göre filtrelenebilir.
     */
    public function index(Request $request)
    {
        $reservations = Reservation::with(['guest', 'room'])
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->when($request->from, fn ($q) => $q->whereDate('check_in', '>=', $request->from))
            ->when($request->to, fn ($q) => $q->whereDate('check_out', '<=', $request->to))
            ->orderByDesc('check_in')
            ->paginate(15)
            ->withQueryString();

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Yeni rezervasyon formunu gösterir.
     */
    public function create()
    {
        $guests = Guest::orderBy('last_name')->get();
        $rooms = Room::where('status', '!=', 'bakim')->orderBy('number')->get();

        return view('reservations.create', compact('guests', 'rooms'));
    }

    /**
     * Yeni rezervasyonu kaydeder.
     */
    public function store(StoreReservationRequest $request)
    {
        $reservation = Reservation::create($request->validated());

        if ($reservation->status === 'giris_yapildi') {
            $reservation->room->update(['status' => 'dolu']);
        }

        return redirect()
            ->route('rezervasyonlar.index')
            ->with('success', 'Rezervasyon başarıyla oluşturuldu.');
    }

    /**
     * Rezervasyon düzenleme formunu gösterir.
     */
    public function edit(Reservation $rezervasyon)
    {
        $guests = Guest::orderBy('last_name')->get();
        $rooms = Room::orderBy('number')->get();

        return view('reservations.edit', [
            'reservation' => $rezervasyon,
            'guests' => $guests,
            'rooms' => $rooms,
        ]);
    }

    /**
     * Rezervasyon bilgilerini günceller.
     */
    public function update(UpdateReservationRequest $request, Reservation $rezervasyon)
    {
        $oldStatus = $rezervasyon->status;
        $rezervasyon->update($request->validated());
        $rezervasyon->refresh();

        $this->syncRoomStatus($rezervasyon, $oldStatus);

        return redirect()
            ->route('rezervasyonlar.index')
            ->with('success', 'Rezervasyon başarıyla güncellendi.');
    }

    /**
     * Rezervasyonu iptal eder.
     */
    public function cancel(Reservation $rezervasyon)
    {
        if ($rezervasyon->status === 'cikis_yapildi') {
            return back()->with('error', 'Çıkış yapılmış rezervasyon iptal edilemez.');
        }

        $wasCheckedIn = $rezervasyon->status === 'giris_yapildi';

        $rezervasyon->update(['status' => 'iptal']);

        if ($wasCheckedIn) {
            $rezervasyon->room->update(['status' => 'musait']);
        }

        return back()->with('success', 'Rezervasyon iptal edildi.');
    }

    /**
     * Misafirin giriş yapmasını sağlar; oda durumunu dolu yapar.
     */
    public function checkIn(Reservation $rezervasyon)
    {
        if ($rezervasyon->status !== 'beklemede') {
            return back()->with('error', 'Sadece beklemedeki rezervasyonlar için giriş yapılabilir.');
        }

        $rezervasyon->update(['status' => 'giris_yapildi']);
        $rezervasyon->room->update(['status' => 'dolu']);

        return back()->with('success', 'Giriş işlemi tamamlandı.');
    }

    /**
     * Misafirin çıkış yapmasını sağlar; oda durumunu müsait yapar.
     */
    public function checkOut(Reservation $rezervasyon)
    {
        if ($rezervasyon->status !== 'giris_yapildi') {
            return back()->with('error', 'Sadece giriş yapılmış rezervasyonlar için çıkış yapılabilir.');
        }

        $rezervasyon->update(['status' => 'cikis_yapildi']);
        $rezervasyon->room->update(['status' => 'musait']);

        return back()->with('success', 'Çıkış işlemi tamamlandı.');
    }

    /** Rezervasyon durumu değişince oda durumunu senkronize eder */
    private function syncRoomStatus(Reservation $reservation, string $oldStatus): void
    {
        if ($reservation->status === 'giris_yapildi') {
            $reservation->room->update(['status' => 'dolu']);
        } elseif (in_array($reservation->status, ['cikis_yapildi', 'iptal']) && $oldStatus === 'giris_yapildi') {
            $reservation->room->update(['status' => 'musait']);
        }
    }
}
