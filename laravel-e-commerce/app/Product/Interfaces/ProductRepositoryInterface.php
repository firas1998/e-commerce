<?php

namespace App\Product\Interfaces;

use App\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAllProducts(): LengthAwarePaginator;
    public function getProductById(int $productId): Product;
}
