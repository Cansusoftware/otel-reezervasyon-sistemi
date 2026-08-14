<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Room;

class DashboardController extends Controller
{
    /**
     * Ana panel: bugünkü giriş/çıkışlar ve özet istatistikler.
     */
    public function index()
    {
        $todayCheckIns = Reservation::with(['guest', 'room'])
            ->whereDate('check_in', today())
            ->where('status', 'beklemede')
            ->orderBy('check_in')
            ->get();

        $todayCheckOuts = Reservation::with(['guest', 'room'])
            ->whereDate('check_out', today())
            ->where('status', 'giris_yapildi')
            ->orderBy('check_out')
            ->get();

        $stats = [
            'total_rooms' => Room::count(),
            'available_rooms' => Room::where('status', 'musait')->count(),
            'occupied_rooms' => Room::where('status', 'dolu')->count(),
            'active_reservations' => Reservation::whereIn('status', ['beklemede', 'giris_yapildi'])->count(),
        ];

        $recentReservations = Reservation::with(['guest', 'room'])
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'todayCheckIns',
            'todayCheckOuts',
            'stats',
            'recentReservations'
        ));
    }
}
