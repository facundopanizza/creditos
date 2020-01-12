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
    Route::get('/users/{user}/resume/shares', 'UsersController@resumeShares');
    Route::get('/users/{user}/resume/credits', 'UsersController@resumeCredits');
    Route::get('/users/{user}/resume/expenses', 'UsersController@resumeExpenses');
    Route::get('/users/{user}/resume/cash_entry', 'InitialCashController@individualCashEntryStore');
    Route::get('/disabled-users', 'UsersController@disabledUsers');
    Route::get('/users/{user}/cash_allocation', 'CashAllocationController@create');
    Route::get('/sellers-report', 'UsersController@sellersReport');
    Route::post('/sellers-report/find-report', 'UsersController@findReport');
    Route::post('/users/{user}/cash_allocation', 'CashAllocationController@store');
    Route::put('/users/{user}', 'UsersController@update');
    Route::put('/users/{user}/disable', 'UsersController@disable');
    Route::put('/users/{user}/enable', 'UsersController@enable');
    Route::get('/users/{user}/clients', 'UsersController@clientsView');

    Route::get('/pay-to-users', 'SellerPaymentController@payToUsers');
    Route::get('/seller_payments', 'SellerPaymentController@index');
    Route::get('/users/{user}/payments/create', 'SellerPaymentController@create');
    Route::post('/users/{user}/payments', 'SellerPaymentController@store');

    Route::resource('clients', 'ClientsController');
    Route::post('/search/clients', 'ClientsController@search');
    Route::post('/search/sellers', 'UsersController@search');

    Route::resource('credits', 'CreditsController');
    Route::get('/clients/{client}/credits/create', 'CreditsController@create');
    Route::get('/shares/{share}/share_payments', 'SharePaymentsController@create');
    Route::post('/shares/{share}/share_payments', 'SharePaymentsController@store');
    Route::get('/shares/{share}', 'SharePaymentsController@show'); // Print
    Route::get('/shares/{share}/payment/{sharePayment}', 'SharePaymentsController@print'); // Print

    Route::get('/initial_cash', 'InitialCashController@index');
    Route::post('/initial_cash', 'InitialCashController@store');
    Route::get('/cash_entries', 'InitialCashController@cashEntry');
    Route::post('/cash_entries', 'InitialCashController@cashEntryStore');
    Route::get('/expenses_box', 'ExpensesBoxController@index');
    Route::get('/expenses_box/create', 'ExpensesBoxController@create');
    Route::post('/expenses_box', 'ExpensesBoxController@store');
    Route::get('/expenses_box/{expensesBox}', 'ExpensesBoxController@show');
    Route::get('/close_day', 'InitialCashController@closeDay');
    Route::post('/close_day', 'InitialCashController@closeDayStore');
    Route::get('/closed_days', 'InitialCashController@closedDays');
    Route::get('/add_money', 'InitialCashController@addMoney');
    Route::post('/add_money', 'InitialCashController@addMoneyStore');

    Route::resource('expenses', 'ExpenseController');

    Route::get('/consult', 'StaticPagesController@consult');
    Route::post('/consult/seller', 'StaticPagesController@sellerConsult');
    Route::post('/consult/client', 'StaticPagesController@clientConsult');
    Route::post('/consult/close_day', 'StaticPagesController@closeDayConsult');

    Route::get('/defaults/maximum_credit', 'DefaultValueController@edit');
    Route::put('/defaults/maximum_credit', 'DefaultValueController@update');
});
