<?php

namespace Database\Factories\Product\Models;

use App\Favorite\Models\Favorite;
use App\Product\Models\Product;
use App\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'price' => $this->faker->randomFloat(1, 1, 100),
            'description' => $this->faker->text(),
            'image_url' => $this->faker->imageUrl()
        ];
    }
}
