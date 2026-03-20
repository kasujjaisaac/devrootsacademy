<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Default seeding is production-safe: create only the admin account.
        // Run `php artisan db:seed --class=DemoDataSeeder` manually if demo data is ever needed.
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
