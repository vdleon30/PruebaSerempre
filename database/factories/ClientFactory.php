<?php

namespace Database\Factories;

use App\Models\City;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'    => $this->faker->name(),
            'cod'     => strtoupper(Str::random(6)),
            'city_id' => City::inRandomOrder()->first() ? City::inRandomOrder()->first() : City::factory(),
        ];
    }
}
