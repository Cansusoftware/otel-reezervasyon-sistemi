<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Oda listesini gösterir. Duruma göre filtreleme destekler.
     */
    public function index(Request $request)
    {
        $rooms = Room::query()
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->orderBy('number')
            ->paginate(15)
            ->withQueryString();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Yeni oda ekleme formunu gösterir.
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Yeni odayı veritabanına kaydeder.
     */
    public function store(StoreRoomRequest $request)
    {
        Room::create($request->validated());

        return redirect()
            ->route('odalar.index')
            ->with('success', 'Oda başarıyla eklendi.');
    }

    /**
     * Oda düzenleme formunu gösterir.
     */
    public function edit(Room $oda)
    {
        return view('rooms.edit', ['room' => $oda]);
    }

    /**
     * Oda bilgilerini günceller.
     */
    public function update(UpdateRoomRequest $request, Room $oda)
    {
        $oda->update($request->validated());

        return redirect()
            ->route('odalar.index')
            ->with('success', 'Oda başarıyla güncellendi.');
    }

    /**
     * Odayı siler. Aktif rezervasyonu varsa silmeye izin vermez.
     */
    public function destroy(Room $oda)
    {
        $hasActive = $oda->reservations()
            ->whereIn('status', ['beklemede', 'giris_yapildi'])
            ->exists();

        if ($hasActive) {
            return back()->with('error', 'Bu odanın aktif rezervasyonu var, silinemez.');
        }

        $oda->delete();

        return redirect()
            ->route('odalar.index')
            ->with('success', 'Oda başarıyla silindi.');
    }
}
