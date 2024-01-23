<?php

namespace App\Cart\Repositories;

use App\Base\Repositories\BaseRepository;
use App\Cart\Interfaces\CartProductRepositoryInterface;
use App\Cart\Models\CartProduct;
use Symfony\Component\HttpKernel\Exception\HttpException;


class CartProductRepository extends BaseRepository implements CartProductRepositoryInterface
{
    public function __construct(CartProduct $model)
    {
        parent::__construct($model);
    }

    public function addProductToCart(int $productId, int $sizeId, int $colorId, int $cartId): void
    {
        $this->model->create(['product_id' => $productId, 'size_id' => $sizeId, 'color_id' => $colorId, 'cart_id' => $cartId]);
    }

    public function removeProductFromCart(int $cartProductId): void
    {
        $cartProduct = $this->model->find($cartProductId);
        if (!$cartProduct) {
            throw new HttpException(404, 'This product is not in your cart');
        }
        $this->model->destroy($cartProduct['id']);
    }
}
