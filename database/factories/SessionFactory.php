<?php

namespace Database\Factories;

use App\Models\Session;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SessionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Session::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'   => User::factory(),
            'activated' => $this->faker->dateTimeBetween('-5 months'),
            'appointment' => $this->faker->dateTimeBetween('-4 months')
        ];
    }
}
