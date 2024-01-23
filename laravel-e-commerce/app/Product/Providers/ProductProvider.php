<?php

namespace App\Product\Providers;

use App\Product\Interfaces\ProductRepositoryInterface;
use App\Product\Interfaces\ProductServiceInterface;
use App\Product\Repositories\ProductRepository;
use App\Product\Services\ProductService;
use Illuminate\Support\ServiceProvider;

/** 
 * Class ProductServiceProvider 
 * @package App\Providers 
 */
class ProductProvider extends ServiceProvider
{
    /** 
     * Register services. 
     * 
     * @return void  
     */
    public function register()
    {
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(ProductServiceInterface::class, ProductService::class);
    }
}
