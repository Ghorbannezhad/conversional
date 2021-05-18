<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'customer_id'   => Customer::factory(),
            'email'         => $this->faker->unique()->safeEmail(),
            'state'         => null,
            'created_at'    => $this->faker->dateTimeBetween('-2 months')->format('Y-m-d'),
            'updated_at'    => $this->faker->dateTimeBetween('-1 months')->format('Y-m-d'),
        ];
    }

}
