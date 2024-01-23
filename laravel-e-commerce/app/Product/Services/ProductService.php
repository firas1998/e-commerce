<?php

namespace App\Product\Services;

use App\Product\Interfaces\ProductServiceInterface;
use App\Product\Models\Product;
use App\Product\Repositories\ProductRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService implements ProductServiceInterface
{

    public function __construct(private ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProducts(): LengthAwarePaginator
    {
        return $this->productRepository->getAllProducts();
    }

    public function getProductById(int $productId): Product
    {
        $product = $this->productRepository->getProductById($productId);
        $product->load('sizes', 'colors');
        return $product;
    }
}
