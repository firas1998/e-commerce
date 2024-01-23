<?php

namespace App\Cart\Interfaces;

use App\Cart\Models\Cart;

interface CartProductRepositoryInterface
{
    public function addProductToCart(int $productId, int $sizeId, int $colorId, int $cartId): void;
    public function removeProductFromCart(int $cartProductId): void;
}
