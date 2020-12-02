<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::group(['prefix' => 'api'], static function () {

    Route::post('user/enter', ['uses' => 'UserController@welcomeUser']);

    Route::group(['middleware' => 'auth'], static function () {
        Route::get('user', ['uses' => 'UserController@getAuthUser']);
        Route::post('declare-winner', ['uses' => 'GameController@declareWinner']);
        Route::post('coins-trophies', ['uses' => 'UserController@getUserCoinsAndTrophies']);
        Route::post('start-multiplayer-game', ['uses' => 'GameController@startMultiPlayerGame']);
        Route::post('start-singleplayer-game', ['uses' => 'GameController@startSinglePlayerGame']);
        Route::post('purchase-item', ['uses' => 'PurchasedItemController@purchaseItem']);
        Route::get('get-purchased-items', ['uses' => 'PurchasedItemController@getPurchasedItems']);
    });
});
