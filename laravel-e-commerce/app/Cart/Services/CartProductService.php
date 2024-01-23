<?php

namespace App\Cart\Services;

use App\Cart\Interfaces\CartProductRepositoryInterface;
use App\Cart\Interfaces\CartProductServiceInterface;

class CartProductService implements CartProductServiceInterface
{

    public function __construct(private CartProductRepositoryInterface $cartProductRepository)
    {
        $this->cartProductRepository = $cartProductRepository;
    }

    public function addProductToCart(int $productId, int $sizeId, int $colorId, int $cartId): void
    {
        $this->cartProductRepository->addProductToCart($productId, $sizeId, $colorId, $cartId);
    }

    public function removeProductFromCart(int $cartProductId): void
    {
        $this->cartProductRepository->removeProductFromCart($cartProductId);
    }
}
