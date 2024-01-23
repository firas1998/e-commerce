<?php

namespace App\Product\Repositories;

use App\Base\Repositories\BaseRepository;
use App\Product\Interfaces\ProductRepositoryInterface;
use App\Product\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

    /**
     * ProductRepository constructor.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function getAllProducts(): LengthAwarePaginator
    {
        return $this->model->with(['sizes', 'colors'])->paginate();
    }

    public function getProductById(int $productId): Product
    {
        return $this->find($productId);
    }
}
