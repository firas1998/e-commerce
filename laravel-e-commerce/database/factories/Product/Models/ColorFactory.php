<?php

namespace Database\Factories\Product\Models;

use App\Favorite\Models\Favorite;
use App\Product\Models\Color;
use App\Product\Models\Product;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ColorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Color::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'color' => $this->faker->randomElement(['black', 'white', 'red'])
        ];
    }
}
