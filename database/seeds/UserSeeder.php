<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@egat.co.th',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
        ]);

        // กำหนด role admin ให้ user
        $admin->assignRole('admin');
    }
}
