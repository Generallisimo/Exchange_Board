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
		
		Route::get('users', ['as' => 'check.users', 'uses' => 'App\Http\Controllers\UsersCheckController@index']);
		Route::delete('users/delete/{id}', ['as' => 'user.delete', 'uses' => 'App\Http\Controllers\UsersCheckController@deleteUser']);
		Route::get('users/update/{id}', ['as' => 'user.update.check', 'uses' => 'App\Http\Controllers\UsersCheckController@update']);
		Route::put('users/update/change{id}', ['as' => 'user.update.change', 'uses' => 'App\Http\Controllers\UsersCheckController@updateUser']);
		Route::put('users/update/change{id}/status', ['as' => 'user.update.change.status', 'uses' => 'App\Http\Controllers\UsersCheckController@updateUserStatus']);
		Route::get('users/update/change_details/view{id}', ['as' => 'user.update.check.details', 'uses' => 'App\Http\Controllers\UsersCheckController@walletMarket']);
		Route::get('users/update/change_details/view/change{id}', ['as' => 'user.update.check.details.view', 'uses' => 'App\Http\Controllers\UsersCheckController@wallet']);
		Route::put('users/update/change_details/view/update{id}', ['as' => 'user.update.change.details', 'uses' => 'App\Http\Controllers\UsersCheckController@changeWalletMarkets']);
		Route::put('users/update/change_details/view/status', ['as'=>'change.status.wallet', 'uses'=> 'App\Http\Controllers\UsersCheckController@changeStatus']);
		
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
