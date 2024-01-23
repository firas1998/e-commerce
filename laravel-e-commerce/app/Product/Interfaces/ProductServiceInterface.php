<?php

namespace App\Product\Interfaces;

use App\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function getAllProducts(): LengthAwarePaginator;
    public function getProductById(int $productId): Product;
}
