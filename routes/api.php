<?php

use Illuminate\Http\Request;

Route::group(['prefix' => 'products'], function () {
    Route::get('/last', 'ProductController@lastProducts');

    Route::get('/', 'ProductController@index');
    Route::post('/', 'ProductController@create');
    Route::get('/{product_uuid}', 'ProductController@product');
    Route::delete('/{product_uuid}', 'ProductController@delete');
    Route::put('/{product_uuid}', 'ProductController@update');

});




