<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Varsayılan admin kullanıcısını oluşturur.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@frontdesk.local'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
            ]
        );
    }
}
