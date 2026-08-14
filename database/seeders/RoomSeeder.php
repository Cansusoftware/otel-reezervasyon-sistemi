<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Örnek odaları oluşturur.
     */
    public function run(): void
    {
        $rooms = [
            ['number' => '101', 'type' => 'tek', 'status' => 'musait', 'price_per_night' => 800, 'capacity' => 1],
            ['number' => '102', 'type' => 'tek', 'status' => 'musait', 'price_per_night' => 800, 'capacity' => 1],
            ['number' => '201', 'type' => 'cift', 'status' => 'musait', 'price_per_night' => 1200, 'capacity' => 2],
            ['number' => '202', 'type' => 'cift', 'status' => 'musait', 'price_per_night' => 1200, 'capacity' => 2],
            ['number' => '203', 'type' => 'cift', 'status' => 'musait', 'price_per_night' => 1200, 'capacity' => 2],
            ['number' => '301', 'type' => 'suit', 'status' => 'musait', 'price_per_night' => 2500, 'capacity' => 3],
            ['number' => '302', 'type' => 'suit', 'status' => 'bakim', 'price_per_night' => 2500, 'capacity' => 3],
            ['number' => '401', 'type' => 'cift', 'status' => 'musait', 'price_per_night' => 1500, 'capacity' => 2],
            ['number' => '402', 'type' => 'tek', 'status' => 'musait', 'price_per_night' => 900, 'capacity' => 1],
            ['number' => '501', 'type' => 'suit', 'status' => 'musait', 'price_per_night' => 3000, 'capacity' => 4],
        ];

        foreach ($rooms as $room) {
            Room::updateOrCreate(['number' => $room['number']], $room);
        }
    }
}
