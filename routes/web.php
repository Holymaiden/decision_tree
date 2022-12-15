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
Route::group(['prefix' => '',  'namespace' => 'App\Http\Controllers\Apps',  'middleware' => ['web']], function () {
    Route::get('/', 'HomeController@index')->name('home');
});

// Route Admin
Route::group(['prefix' => '',  'namespace' => 'App\Http\Controllers\Admin', 'middleware' => ['auth']], function () {
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::group(['prefix' => '/roles'], function () {
            Route::get('/', 'RoleController@index')->name('roles');
            Route::get('/data', 'RoleController@data')->name('roles.data');
            Route::post('/store', 'RoleController@store')->name('roles.store');
            Route::get('/{id}/edit', 'RoleController@edit')->name('roles.edit');
            Route::put('/{id}', 'RoleController@update')->name('roles.update');
            Route::delete('/{id}', 'RoleController@destroy')->name('roles.delete');
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
