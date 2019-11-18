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


Auth::routes();

Route::middleware('auth')->group(function() {
    Route::get('/', 'StaticPagesController@home');

    Route::get('/register', 'Auth\RegisterController@registrationForm')->name('register');
    Route::get('/users', 'UsersController@index');
    Route::get('/users/{user}/edit', 'UsersController@edit');
    Route::get('/users/{user}/resume', 'UsersController@resume');
    Route::get('/disabled-users', 'UsersController@disabledUsers');
    Route::get('/users/{user}/cash_allocation', 'CashAllocationController@create');
    Route::get('/sellers-report', 'UsersController@sellersReport');
    Route::post('/sellers-report/find-report', 'UsersController@findReport');
    Route::post('/users/{user}/cash_allocation', 'CashAllocationController@store');
    Route::put('/users/{user}', 'UsersController@update');
    Route::put('/users/{user}/disable', 'UsersController@disable');
    Route::put('/users/{user}/enable', 'UsersController@enable');


    Route::resource('clients', 'ClientsController');
    Route::post('/search/clients', 'ClientsController@search');
    Route::post('/search/sellers', 'UsersController@search');

    Route::resource('credits', 'CreditsController');
    Route::get('/clients/{client}/credits/create', 'CreditsController@create');
    Route::get('/shares/{share}/share_payments', 'SharePaymentsController@create');
    Route::post('/shares/{share}/share_payments', 'SharePaymentsController@store');

    Route::get('/initial_cash', 'InitialCashController@index');
});