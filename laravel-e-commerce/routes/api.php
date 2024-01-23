<?php

use App\Cart\Controllers\CartController;
use App\Product\Controllers\ProductController;
use App\User\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/user/create', [UserController::class, 'createUser']);
Route::post('/user/login', [UserController::class, 'login']);
Route::middleware('auth:api')->get('/user/refresh', [UserController::class, 'refresh']);
Route::middleware('auth:api')->get('/user/logout', [UserController::class, 'logout']);
Route::middleware('auth:api')->get('/user/me', [UserController::class, 'me']);

Route::middleware('auth:api')->get('/cart', [CartController::class, 'getUserCart']);
Route::middleware('auth:api')->put('/cart/add', [CartController::class, 'addProductToCart']);
Route::middleware('auth:api')->put('/cart/remove', [CartController::class, 'removeProductFromCart']);
Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/product/{productId}', [ProductController::class, 'getProductById']);
