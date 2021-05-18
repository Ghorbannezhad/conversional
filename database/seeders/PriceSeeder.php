<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Seed price with pre defined prices for create, active and make appointment sessions for users
        DB::table('prices')->insert([
            'type' => \App\Models\Price::REGISTERED,
            'price'            => 0.49
        ]);

        DB::table('prices')->insert([
            'type' => \App\Models\Price::ACTIVATION,
            'price'            => 0.99
        ]);

        DB::table('prices')->insert([
            'type' => \App\Models\Price::APPOINTMENT,
            'price'            => 3.99
        ]);

        DB::table('prices')->insert([
            'type' => \App\Models\Price::CREATED_TO_ACTIVATED,
            'price'            => 0.50
        ]);

        DB::table('prices')->insert([
            'type' => \App\Models\Price::CREATED_TO_APPOINTMENT,
            'price'            => 3.50
        ]);

        DB::table('prices')->insert([
            'type' => \App\Models\Price::ACTIVATED_TO_APPOINTMENT,
            'price'            => 3
        ]);
    }
}
