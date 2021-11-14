<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['prefix' => 'users'], function() {
        Route::get('/', 'UsersController@index')->name('users.index');
        Route::get('/create', 'UsersController@create')->name('users.create');
        Route::post('/create', 'UsersController@store')->name('users.store');
        Route::get('/{user}/show', 'UsersController@show')->name('users.show');
        Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
        Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
        Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
        Route::post('/{user}/restore', 'UsersController@restore')->name('users.restore');
        Route::delete('/{user}/force-delete', 'UsersController@forceDelete')->name('users.force-delete');
        Route::post('/restore-all', 'UsersController@restoreAll')->name('users.restore-all');
    });
});
