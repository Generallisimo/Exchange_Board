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

Route::get('api/payment/{client}/{amount}', ['as' => 'exchange', 'uses' => 'App\Http\Controllers\ExchangeController@index']);
Route::put('api/payment/{client}/{market}/{amount}/{exchange_id}', ['as' => 'exchange.confirm', 'uses' => 'App\Http\Controllers\ExchangeController@exchange']);
Route::put('api/payment/', ['as' => 'exchange.success', 'uses' => 'App\Http\Controllers\ExchangeController@transaction']);
Route::get('api/payment/{exchange}', ['as' => 'exchange.status', 'uses' => 'App\Http\Controllers\ExchangeController@checkStatus']);

Route::get('api/top_up/{wallet}/{amount}/{hash_id}', ['as' => 'api.top_up', 'uses' => 'App\Http\Controllers\TopUpController@checkTopUp']);

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware(['auth', 'role']);

Route::group(['middleware' => 'auth'], function () {
	Route::group(['prefix'=>'create_users'], function (){
		Route::get('/', ['as' => 'create.users', 'uses' => '\App\Http\Controllers\Users\IndexController']);
		Route::post('/store', ['as'=>'store.users', 'uses'=>'App\Http\Controllers\Users\StoreController']);
	});
	
	Route::group(['prefix'=>'new_details'], function(){
		Route::get('/', ['as' => 'create.details', 'uses' => 'App\Http\Controllers\Users\Details\IndexController']);
		Route::post('/store', ['as'=>'store.details', 'uses'=> 'App\Http\Controllers\Users\Details\StoreController']);
	});
	
	Route::group(['prefix'=>'users'], function(){
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
	
		
		Route::get('withdrawal', ['as' => 'withdrawal', 'uses' => 'App\Http\Controllers\WithdrawalController@index']);
		Route::post('withdrawal/check', ['as' => 'withdrawal.check', 'uses' => 'App\Http\Controllers\WithdrawalController@withdrawal']);
		
		Route::get('top_up', ['as' => 'top_up', 'uses' => 'App\Http\Controllers\TopUpController@index']);
		Route::post('top_up/check', ['as' => 'top_up.check', 'uses' => 'App\Http\Controllers\TopUpController@topUp']);
		

		Route::get('market_board', ['as' => 'market.board', 'uses' => 'App\Http\Controllers\MarketBoardController@index']);
		Route::put('market_board/{exchange}', ['as' => 'market.success', 'uses' => 'App\Http\Controllers\MarketBoardController@success']);
		Route::put('market_board/archive/{exchange}', ['as' => 'market.archive', 'uses' => 'App\Http\Controllers\MarketBoardController@archive']);
		Route::put('market_board/dispute/{exchange}', ['as' => 'market.dispute', 'uses' => 'App\Http\Controllers\MarketBoardController@dispute']);
		
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Auth::routes();
