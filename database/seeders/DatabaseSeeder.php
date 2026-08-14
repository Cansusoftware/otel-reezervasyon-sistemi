<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Uygulama veritabanını örnek verilerle doldurur.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            RoomSeeder::class,
            GuestSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
