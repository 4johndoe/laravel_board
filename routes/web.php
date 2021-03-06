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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/verify/{token}', 'Auth\RegisterController@verify')->name('register.verify');

Route::get('/cabinet', 'Cabinet\HomeController@index')->name('cabinet');

Route::group([
    'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'can:admin-panel']
],
    function() {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('users', 'UsersController');
        Route::post('users/verify/{user}', 'UsersController@verify')->name('users.verify');

        Route::resource('regions', 'RegionController');

        Route::group(['prefix' => 'adverts','as' => 'adverts.','namespace' => 'Adverts'], function() {
            Route::resource('categories', 'CategoryController');

            Route::group(['prefix' => 'categories/{category}','as' => 'categories.'], function() {
                Route::post('first','CategoryController@first')->name('first');
                Route::post('up','CategoryController@up')->name('up');
                Route::post('down','CategoryController@down')->name('down');
                Route::post('last','CategoryController@last')->name('last');

                Route::resource('attributes', 'AttributeController')->except('index');
            });
        });
    }
);
