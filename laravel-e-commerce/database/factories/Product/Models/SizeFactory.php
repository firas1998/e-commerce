<?php

namespace Database\Factories\Product\Models;

use App\Favorite\Models\Favorite;
use App\Product\Models\Product;
use App\Product\Models\Size;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class SizeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Size::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'size' => $this->faker->randomElement(['large', 'small', 'medium'])
        ];
    }
}
