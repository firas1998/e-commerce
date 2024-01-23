<?php

namespace App\Cart\Repositories;

use App\Base\Repositories\BaseRepository;
use App\Cart\Interfaces\CartRepositoryInterface;
use App\Cart\Models\Cart;

class CartRepository extends BaseRepository implements CartRepositoryInterface
{
    public function __construct(Cart $model)
    {
        parent::__construct($model);
    }

    public function getUserCart(int $userId): ?Cart
    {
        return $this->model->where('user_id', $userId)->get()->first();
    }

    public function createCart(int $userId): Cart
    {
        return $this->create(['user_id' => $userId]);
    }
}
