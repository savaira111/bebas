<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder Super Admin
        $this->call([
            SuperAdminSeeder::class,
        ]);

        // (Optional): Seed Admin biasa atau data dummy
        // $this->call(AdminSeeder::class);
        // $this->call(UserSeeder::class);
    }
}
