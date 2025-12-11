<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // kalau sudah ada admin, jangan bikin lagi
        if (User::where('role', 'admin')->exists()) {
            return;
        }

        User::updateOrCreate(
            ['email' => 'admin@google.com'],
            [
                'name'     => 'Admin',
                'username' => 'Admin',
                'password' => Hash::make('Admin123'),
                'role'     => 'admin',
            ]
        );
    }
}
