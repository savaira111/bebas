<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Super Admin',
            'username' => 'superadmin1',
            'email' => 'superadmin1@gmail.com',
            'role' => 'superadmin',
            'password' => Hash::make('Superadmin123#'),
            'email_verified_at' => now(),
        ]);
    }
}
