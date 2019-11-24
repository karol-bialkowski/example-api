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

use App\Product;

Route::get('/', function () {

    $fractionalPrice = 100;

    $money = new App\Money\Money($fractionalPrice);

    print_r($money->getPrice(\App\Money\Currency\Eur::class)->getPriceWithSymbol());
    echo '<br>';
    print_r($money->getPrice(\App\Money\Currency\Pln::class)->getPriceWithSymbol());
//
//
//
//
//
//exit;

    $product = Product::where('id', 'e60c142c-a03d-4a5f-b09f-b14bdbeb775a')->first();
    echo $product->name;


//
    echo '<pre>';
        print_r($product->getPrice()->getPriceWithSymbol());
    echo '</pre>';
    echo 'ok';
    exit;


    return view('welcome');
});
