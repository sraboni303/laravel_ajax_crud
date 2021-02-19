<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'App\Http\Controllers'], function(){
    Route::get('/', 'CustomerController@index') -> name('customer.index');
    Route::post('/store', 'CustomerController@store') -> name('customer.store');
    Route::get('/all', 'CustomerController@all') -> name('customer.all');
    Route::get('/view/{id}', 'CustomerController@view') -> name('customer.view');
    Route::get('/edit/{id}', 'CustomerController@edit') -> name('customer.edit');
    Route::get('/delete/{id}', 'CustomerController@delete') -> name('customer.delete');
    Route::post('/update', 'CustomerController@update') -> name('customer.update');
    Route::get('/status/{id}', 'CustomerController@status') -> name('customer.status');
});