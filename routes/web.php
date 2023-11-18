<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController as Auths;


Route::get('/', function () {
    return view('welcome');
});

// Route Auth
Route::get('/auth/login', [Auths::class, 'index']);
Route::post('/auth/login', [Auths::class, 'login'])->name('login');
Route::get('/auth/logout', [Auths::class, 'logout'])->name('logout');

// Route User
Route::group(['prefix' => '',  'namespace' => 'App\Http\Controllers\Apps',  'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/data', 'HomeController@data')->name('home.data');
    Route::get('/kata-kunci', 'HomeController@kataKunci')->name('home.kata-kunci');

    Route::group(['prefix' => '/carts'], function () {
        Route::get('/', 'CartController@index')->name('carts');
        Route::get('/data', 'CartController@data')->name('carts.data');
        Route::post('/update/{id}', 'CartController@update')->name('drugs.update');
        Route::post('/store', 'CartController@store')->name('carts.store');
        Route::delete('/{id}', 'CartController@destroy')->name('carts.delete');
        Route::post('/proses/transaksi', 'CartController@proses')->name('carts.proses');
    });
});

// Route Admin
Route::group(['prefix' => '',  'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::group(['prefix' => '/drugs'], function () {
            Route::get('/', 'DrugController@index')->name('drugs');
            Route::get('/data', 'DrugController@data')->name('drugs.data');
            Route::post('/store', 'DrugController@store')->name('drugs.store');
            Route::get('/{id}/edit', 'DrugController@edit')->name('drugs.edit');
            Route::put('/{id}', 'DrugController@update')->name('drugs.update');
            Route::delete('/{id}', 'DrugController@destroy')->name('drugs.delete');
            Route::get('/decisionTree', 'DrugController@decisionTree')->name('drugs.decisionTree');
        });

        Route::group(['prefix' => '/sales'], function () {
            Route::get('/', 'SaleController@index')->name('sales');
            Route::get('/data', 'SaleController@data')->name('sales.data');
            Route::post('/store', 'SaleController@store')->name('sales.store');
            Route::get('/{id}/edit', 'SaleController@edit')->name('sales.edit');
            Route::put('/{id}', 'SaleController@update')->name('sales.update');
            Route::delete('/{id}', 'SaleController@destroy')->name('sales.delete');
        });

        Route::group(['prefix' => '/transactions'], function () {
            Route::get('/', 'TransactionController@index')->name('transactions');
            Route::get('/data', 'TransactionController@data')->name('transactions.data');
            Route::post('/store', 'TransactionController@store')->name('transactions.store');
            Route::get('/{id}/edit', 'TransactionController@edit')->name('transactions.edit');
            Route::put('/{id}', 'TransactionController@update')->name('transactions.update');
            Route::delete('/{id}', 'TransactionController@destroy')->name('transactions.delete');
        });

        Route::group(['prefix' => '/users'], function () {
            Route::get('/', 'UserController@index')->name('users');
            Route::get('/data', 'UserController@data')->name('users.data');
            Route::post('/store', 'UserController@store')->name('users.store');
            Route::get('/{id}/edit', 'UserController@edit')->name('users.edit');
            Route::put('/{id}', 'UserController@update')->name('users.update');
            Route::delete('/{id}', 'UserController@destroy')->name('users.delete');
        });
    });
});

// Route Error Handling
Route::get('unauthorized', function ($title = null) {
    $this->response['code'] = "401";
    $this->response['message'] = "unauthorized access permission";
    return view('errors.message', ['message' => $this->response]);
})->name('unauthorized');

// Route Artisan
Route::get('/cc', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
});
