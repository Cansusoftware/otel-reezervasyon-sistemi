<?php

namespace Database\Seeders;

use App\Models\Guest;
use Illuminate\Database\Seeder;

class GuestSeeder extends Seeder
{
    /**
     * Örnek misafirleri oluşturur.
     */
    public function run(): void
    {
        $guests = [
            ['first_name' => 'Ahmet', 'last_name' => 'Yılmaz', 'phone' => '0532 111 2233', 'email' => 'ahmet@email.com', 'id_number' => '12345678901'],
            ['first_name' => 'Ayşe', 'last_name' => 'Kaya', 'phone' => '0533 222 3344', 'email' => 'ayse@email.com', 'id_number' => '23456789012'],
            ['first_name' => 'Mehmet', 'last_name' => 'Demir', 'phone' => '0534 333 4455', 'email' => null, 'id_number' => '34567890123'],
            ['first_name' => 'Fatma', 'last_name' => 'Çelik', 'phone' => '0535 444 5566', 'email' => 'fatma@email.com', 'id_number' => null],
            ['first_name' => 'John', 'last_name' => 'Smith', 'phone' => '0536 555 6677', 'email' => 'john@email.com', 'id_number' => 'AB1234567'],
        ];

        foreach ($guests as $guest) {
            Guest::updateOrCreate(
                ['phone' => $guest['phone']],
                $guest
            );
        }
    }
}
