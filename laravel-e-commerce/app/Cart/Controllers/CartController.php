<?php

namespace App\Cart\Controllers;

use App\Cart\Interfaces\CartServiceInterface;
use App\Cart\Requests\AddProductRequest;
use App\Cart\Requests\RemoveProductRequest;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CartController extends Controller
{

    public function __construct(private CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function getUserCart()
    {
        try {
            $cart = $this->cartService->getUserCart();
            return response()->json($cart, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }

    public function addProductToCart(AddProductRequest $req)
    {
        $validated = $req->validated();
        try {
            $cart = $this->cartService->addProductToCart($validated['product_id'], $validated['size_id'], $validated['color_id']);

            return response()->json($cart, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }

    public function removeProductFromCart(RemoveProductRequest $req)
    {
        $productId = $req->validated()['cart_product_id'];
        try {
            $cart = $this->cartService->removeProductFromCart($productId);
            return response()->json($cart, 200);
        } catch (HttpException $e) {
            return response()->json($e->getMessage(), $e->getStatusCode());
        }
    }
}
