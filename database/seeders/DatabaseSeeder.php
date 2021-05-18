<?php

namespace Database\Seeders;

use Database\Factories\CustomerFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PriceSeeder::class,
            CustomerSeeder::class,
            SessionSeeder::class,

        ]);
    }
}
