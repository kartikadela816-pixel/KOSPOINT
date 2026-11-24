<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Aman dijalankan berulang kali (memakai updateOrCreate).
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            KosSeeder::class,
        ]);
    }
}
