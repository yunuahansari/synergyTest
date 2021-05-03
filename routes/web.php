<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('products','ProductController@products');
Route::get('product_list','ProductController@productList');
Route::get('add-to-cart/{id}', 'ProductController@addToCart');
Route::get('cart-list', 'ProductController@cartList');
Route::get('remove-from-cart', 'ProductController@removeFromCart');
Route::get('clear-cart', 'ProductController@clearCart');
Route::get('get-index-difference', 'ProductController@getabsoluteDiffrence');
Route::get('get-iuser-list', 'ProductController@getUserList');


Route::get('/', function () {
    return view('welcome');
});
