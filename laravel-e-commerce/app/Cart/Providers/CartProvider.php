<?php

namespace App\Cart\Providers;

use App\Cart\Interfaces\CartRepositoryInterface;
use App\Cart\Interfaces\CartServiceInterface;
use App\Cart\Interfaces\CartProductRepositoryInterface;
use App\Cart\Interfaces\CartProductServiceInterface;
use App\Cart\Repositories\CartRepository;
use App\Cart\Services\CartService;
use App\Cart\Repositories\CartProductRepository;
use App\Cart\Services\CartProductService;
use Illuminate\Support\ServiceProvider;

/** 
 * Class CartServiceProvider 
 * @package App\Providers 
 */
class CartProvider extends ServiceProvider
{
    /** 
     * Register services. 
     * 
     * @return void  
     */
    public function register()
    {
        $this->app->bind(CartRepositoryInterface::class, CartRepository::class);
        $this->app->bind(CartServiceInterface::class, CartService::class);
        $this->app->bind(CartProductRepositoryInterface::class, CartProductRepository::class);
        $this->app->bind(CartProductServiceInterface::class, CartProductService::class);
    }
}
