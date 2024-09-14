<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
// use Spatie\Permission\Contracts\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
	Route::get('/home',['as'=>'home', 'uses'=> 'App\Http\Controllers\HomeController@index']);

	Route::group(['prefix'=>'market_details'], function(){
		Route::get('/create', ['as' => 'create.details', 'uses' => 'App\Http\Controllers\Users\Details\IndexController']);
		Route::post('/store', ['as'=>'store.details', 'uses'=> 'App\Http\Controllers\Users\Details\StoreController']);
	});
	
	Route::group(['prefix'=>'users'], function(){
		Route::get('/create', ['as' => 'create.users', 'uses' => '\App\Http\Controllers\Users\IndexController']);
		Route::post('/store', ['as'=>'store.users', 'uses'=>'App\Http\Controllers\Users\StoreController']);

		Route::get('/', ['as' => 'table.users.index', 'uses' => 'App\Http\Controllers\Users\Table\IndexController']);
		Route::delete('/delete/{hash_id}', ['as' => 'table.user.destroy', 'uses' => 'App\Http\Controllers\Users\Table\DestroyController']);
		Route::get('/edit/{hash_id}', ['as' => 'table.user.edit', 'uses' => 'App\Http\Controllers\Users\Table\EditController']);
		Route::put('/update/{hash_id}', ['as' => 'table.user.update', 'uses' => 'App\Http\Controllers\Users\Table\UpdateController']);
		
		Route::group(['prefix'=>'market'], function(){
			Route::get('/{hash_id}', ['as' => 'table.user.market.show', 'uses' => 'App\Http\Controllers\Users\Table\Market\ShowController']);
			Route::put('/status/update/{hash_id}', ['as' => 'table.user.market.update', 'uses' => 'App\Http\Controllers\Users\Table\Market\UpdateController']);
			
			Route::group(['prefix'=>'wallet'], function(){
				Route::get('/edit/{id}', ['as' => 'table.user.market.edit', 'uses' => 'App\Http\Controllers\Users\Table\Market\EditController']);
				Route::put('/update', ['as' => 'table.user.market.wallet.update', 'uses' => 'App\Http\Controllers\Users\Table\Market\Wallet\UpdateController']);
				Route::put('/update/status/{id}', ['as'=>'table.user.market.wallet.status.update', 'uses'=> 'App\Http\Controllers\Users\Table\Market\Wallet\UpdateStatusController']);
			});
		});
	});
	
	Route::group(['prefix'=>'transactions'], function(){
		Route::get('/', ['as' => 'transaction.index', 'uses' => 'App\Http\Controllers\Transactions\IndexController']);
		Route::put('/{exchange_id}/{status}/{message}', ['as' => 'transaction.update', 'uses' => 'App\Http\Controllers\Transactions\UpdateController']);
	});

	Route::group(['prefix'=>'withdrawal'], function(){
		Route::get('/', ['as' => 'withdrawal.index', 'uses' => 'App\Http\Controllers\Withdrawal\IndexController']);
		Route::post('/update', ['as' => 'withdrawal.update', 'uses' => 'App\Http\Controllers\Withdrawal\UpdateController']);
	});

	Route::group(['prefix'=>'top_up'], function(){
		Route::get('/', ['as' => 'top_up.index', 'uses' => 'App\Http\Controllers\TopUp\IndexController']);
		Route::post('/show', ['as' => 'top_up.show', 'uses' => 'App\Http\Controllers\TopUp\ShowController']);
		// Route::post('/update', ['as' => 'top_up.update', 'uses' => 'App\Http\Controllers\Withdrawal\UpdateController']);
	});
		
	Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);		
});

Auth::routes();

Route::group(['prefix'=>'support', 'middleware' => ['guest']], function(){
	Route::get('/', ['as'=>'support.index', 'uses'=>'App\Http\Controllers\Support\IndexController']);
	Route::get('/show/{chat_id}', ['as'=>'support.show', 'uses'=>'App\Http\Controllers\Support\ShowController']);
});



// a0D1m0i1n8