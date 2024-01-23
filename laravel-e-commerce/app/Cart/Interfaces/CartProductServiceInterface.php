<?php

namespace App\Cart\Interfaces;

use App\Cart\Models\Cart;

interface CartProductServiceInterface
{
    public function addProductToCart(int $productId, int $sizeId, int $colorId, int $cartId);
    public function removeProductFromCart(int $cartProductId);
}
