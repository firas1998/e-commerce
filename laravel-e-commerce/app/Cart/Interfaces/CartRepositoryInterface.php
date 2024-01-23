<?php

namespace App\Cart\Interfaces;

use App\Cart\Models\Cart;

interface CartRepositoryInterface
{
    public function getUserCart(int $userId): ?Cart;
    public function createCart(int $userId): Cart;
}
