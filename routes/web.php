<?php

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


Route::resource('product', 'ProductController');
Route::get('get_product_image/{id}', 'ProductController@getProductImage');
Route::get('get_order_product_image/{id}', 'ShoppingController@getProductImage');

Route::get('shopping', 'ShoppingController@index');
Route::post('add_to_cart', 'ShoppingController@addToCart');
Route::get('remove_from_cart/{id}', 'ShoppingController@removeFromCart');
Route::get('view_cart', 'ShoppingController@viewCart');
Route::get('checkout', 'ShoppingController@getCheckout');
Route::post('checkout', 'ShoppingController@postCheckout');
Route::get('orders', 'ShoppingController@viewOrders');

Route::get('/', function () {
    return view('welcome');
});


