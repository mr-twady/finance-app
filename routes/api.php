<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->namespace('Api')->group(function(){                                            
        
    Route::prefix('user')->group(function(){
        Route::get('/', 'UserController@index');
    });

    Route::prefix('entries')->group(function(){
        Route::get('/', 'BalanceEntryController@index');
        Route::post('/', 'BalanceEntryController@store');
        Route::patch('/{id}', 'BalanceEntryController@update');
        Route::delete('/{id}', 'BalanceEntryController@delete');
        Route::post('/import', 'BalanceEntryController@import');
    });

});
