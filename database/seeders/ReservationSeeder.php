<?php

namespace Database\Seeders;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Demo rezervasyonları oluşturur (bugünkü giriş/çıkışlar dahil).
     */
    public function run(): void
    {
        $guests = Guest::all();
        $rooms = Room::where('status', '!=', 'bakim')->get();

        if ($guests->isEmpty() || $rooms->count() < 3) {
            return;
        }

        // Bugün giriş yapacak — beklemede
        Reservation::updateOrCreate(
            ['guest_id' => $guests[0]->id, 'room_id' => $rooms[0]->id, 'check_in' => today()],
            [
                'check_out' => today()->addDays(3),
                'status' => 'beklemede',
                'notes' => 'Erken giriş talep edildi.',
            ]
        );

        // Bugün giriş yapacak — ikinci misafir
        Reservation::updateOrCreate(
            ['guest_id' => $guests[1]->id, 'room_id' => $rooms[1]->id, 'check_in' => today()],
            [
                'check_out' => today()->addDays(2),
                'status' => 'beklemede',
            ]
        );

        // Bugün çıkış yapacak — giriş yapılmış
        $checkOutRoom = $rooms[2];
        Reservation::updateOrCreate(
            ['guest_id' => $guests[2]->id, 'room_id' => $checkOutRoom->id, 'check_out' => today()],
            [
                'check_in' => today()->subDays(2),
                'status' => 'giris_yapildi',
            ]
        );
        $checkOutRoom->update(['status' => 'dolu']);

        // Gelecekteki rezervasyon
        Reservation::updateOrCreate(
            ['guest_id' => $guests[3]->id, 'room_id' => $rooms[3]->id, 'check_in' => today()->addDays(5)],
            [
                'check_out' => today()->addDays(8),
                'status' => 'beklemede',
            ]
        );

        // Geçmiş rezervasyon (çıkış yapılmış)
        Reservation::updateOrCreate(
            ['guest_id' => $guests[4]->id, 'room_id' => $rooms[4]->id, 'check_in' => today()->subDays(10)],
            [
                'check_out' => today()->subDays(7),
                'status' => 'cikis_yapildi',
            ]
        );
    }
}
