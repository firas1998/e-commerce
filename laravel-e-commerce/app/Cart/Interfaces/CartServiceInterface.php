<?php

namespace App\Cart\Interfaces;

use App\Cart\Models\Cart;

interface CartServiceInterface
{
    public function getUserCart(): ?Cart;
    public function addProductToCart(int $productId, int $sizeId, int $colorId): Cart;
    public function removeProductFromCart(int $cartProductId): Cart;
    public function createCart(): Cart;
}
