<?php

use Illuminate\Http\Request;

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('/products', 'ProductController@index');
Route::get('/products/{product_uuid}', 'ProductController@product');
Route::post('/products', 'ProductController@create');
Route::delete('/products/{product_uuid}', 'ProductController@delete');

