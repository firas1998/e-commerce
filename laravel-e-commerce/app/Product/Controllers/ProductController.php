<?php

namespace App\Product\Controllers;

use App\Product\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ProductController extends Controller
{

    public function __construct(private ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function getAllProducts()
    {
        try {
            $products = $this->productService->getAllProducts();
            return response()->json($products, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }

    public function getProductById(int $productId)
    {
        try {
            $products = $this->productService->getProductById($productId);
            return response()->json($products, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }
}
