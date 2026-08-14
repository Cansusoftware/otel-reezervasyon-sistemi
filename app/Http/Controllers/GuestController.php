<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Misafir listesini gösterir. Ad, soyad veya telefona göre arama yapılabilir.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $guests = Guest::query()
            ->when($search, function ($q) use ($search) {
                $q->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(15)
            ->withQueryString();

        return view('guests.index', compact('guests', 'search'));
    }

    /**
     * Yeni misafir ekleme formunu gösterir.
     */
    public function create()
    {
        return view('guests.create');
    }

    /**
     * Yeni misafiri veritabanına kaydeder.
     */
    public function store(StoreGuestRequest $request)
    {
        Guest::create($request->validated());

        return redirect()
            ->route('misafirler.index')
            ->with('success', 'Misafir başarıyla eklendi.');
    }

    /**
     * Misafir detayını ve geçmiş rezervasyonlarını gösterir.
     */
    public function show(Guest $misafir)
    {
        $misafir->load(['reservations' => fn ($q) => $q->with('room')->latest()]);

        return view('guests.show', ['guest' => $misafir]);
    }

    /**
     * Misafir düzenleme formunu gösterir.
     */
    public function edit(Guest $misafir)
    {
        return view('guests.edit', ['guest' => $misafir]);
    }

    /**
     * Misafir bilgilerini günceller.
     */
    public function update(UpdateGuestRequest $request, Guest $misafir)
    {
        $misafir->update($request->validated());

        return redirect()
            ->route('misafirler.index')
            ->with('success', 'Misafir başarıyla güncellendi.');
    }

    /**
     * Misafiri siler.
     */
    public function destroy(Guest $misafir)
    {
        $hasActive = $misafir->reservations()
            ->whereIn('status', ['beklemede', 'giris_yapildi'])
            ->exists();

        if ($hasActive) {
            return back()->with('error', 'Bu misafirin aktif rezervasyonu var, silinemez.');
        }

        $misafir->delete();

        return redirect()
            ->route('misafirler.index')
            ->with('success', 'Misafir başarıyla silindi.');
    }
}
