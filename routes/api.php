<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('top_up/{wallet}/{hash_id}', ['as' => 'api.update', 'uses' => 'App\Http\Controllers\TopUp\UpdateController']);

Route::group(['prefix'=>'payment', 'middleware' => ['web']], function(){
    Route::get('/{client_id}/{amount}/{currency}', ['as' => 'payment.index', 'uses' => 'App\Http\Controllers\Exchanges\IndexController']);
    Route::put('/{client}/{amount}/{currency}/{market}/{exchange_id}', ['as' => 'payment.create', 'uses' => 'App\Http\Controllers\Exchanges\CreateController']);
    Route::put('/{exchange_id}', ['as' => 'payment.store', 'uses' => 'App\Http\Controllers\Exchanges\StoreController']);
    Route::get('/update/{exchange}', ['as' => 'exchange.update', 'uses' => 'App\Http\Controllers\Exchanges\UpdateController']);
});

Route::group(['prefix'=>'support'], function(){
    Route::post('/store', ['as'=>'support.store', 'uses'=>'App\Http\Controllers\Support\StoreController']);
});

Route::group(['prefix'=>'key'], function(){
    Route::get('/{currency}/{amount}/{api_key}', ['as'=>'api_key.store', 'uses'=>'App\Http\Controllers\ApiExchange\StoreController']);
});