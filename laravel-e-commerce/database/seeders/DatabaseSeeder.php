<?php

namespace Database\Seeders;

use App\Product\Models\Color;
use App\Product\Models\Product;
use App\Product\Models\Size;
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
        $size = Size::first();
        if (!is_null($size)) {
            return;
        }
        $smallSize = Size::factory()->create(['size' => 'small']);
        $mediumSize = Size::factory()->create(['size' => 'medium']);
        $largeSize = Size::factory()->create(['size' => 'large']);

        $whiteColor = Color::factory()->create(['color' => 'white']);
        $blackColor = Color::factory()->create(['color' => 'black']);

        for ($i = 0; $i < 100; $i++) {
            $product = Product::factory()->create();
            $product->sizes()->attach($smallSize->id);
            $product->sizes()->attach($mediumSize->id);
            $product->sizes()->attach($largeSize->id);

            $product->colors()->attach($whiteColor->id);
            $product->colors()->attach($blackColor->id);
        }
    }
}
