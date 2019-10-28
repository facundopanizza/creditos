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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', 'UsersController@index');
Route::get('/users/{user}/cash_allocation', 'CashAllocationController@create');
Route::post('/users/{user}/cash_allocation', 'CashAllocationController@store');
Route::get('/users/{user}/resume', 'UsersController@resume');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('clients', 'ClientsController');
Route::post('/search/clients', 'ClientsController@search');

Route::resource('credits', 'CreditsController');
Route::get('/clients/{client}/credits/create', 'CreditsController@create');
Route::get('/shares/{share}/share_payments', 'SharePaymentsController@create');
Route::post('/shares/{share}/share_payments', 'SharePaymentsController@store');

Route::resource('initial_cash', 'InitialCashController');