<?php

namespace App\Cart\Services;

use App\Cart\Interfaces\CartServiceInterface;
use App\Cart\Models\Cart;
use App\Cart\Repositories\CartRepository;

class CartService implements CartServiceInterface
{

    public function __construct(private CartRepository $cartRepository, private CartProductService $cartProductService)
    {
        $this->cartRepository = $cartRepository;
    }

    public function getUserCart(): ?Cart
    {
        $user = auth()->user();
        $cart = $this->cartRepository->getUserCart($user->id);
        if (!$cart) {
            $cart = $this->createCart();
        }
        $cart->load('products');
        foreach ($cart->products as $product) {
            $product->load('product');
            $product->load('size');
            $product->load('color');
        }
        return $cart;
    }

    public function addProductToCart(int $productId, int $sizeId, int $colorId): Cart
    {
        $cart = $this->getUserCart();
        $this->cartProductService->addProductToCart($productId, $sizeId, $colorId, $cart->id);
        return $this->getUserCart();
    }

    public function removeProductFromCart(int $cartProductId): Cart
    {
        $cart = $this->getUserCart();
        $this->cartProductService->removeProductFromCart($cartProductId);
        return $this->getUserCart();
    }

    public function createCart(): Cart
    {
        $user = auth()->user();
        return $this->cartRepository->createCart($user->id);
    }
}
