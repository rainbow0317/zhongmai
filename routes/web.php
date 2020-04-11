<?php

Route::redirect('/', 'products')->name('root');

Auth::routes(['verify' => true]);

Route::middleware('auth')->group(function () {
    Route::middleware('verified')->group(function () {

        // 分享
        Route::post('products/share', 'ProductController@share')->name('products.share');


        //我的订单
        Route::get('orders/income', 'OrderController@income')->name('orders.income');
        Route::get('orders/history', 'OrderController@history')->name('orders.history');
        Route::get('orders/invite', 'OrderController@invite')->name('orders.invite');

        //提现
        Route::get('users/withdraw', 'OrderController@withdraw')->name('users.withdraw');
        Route::post('users/withdraw', 'OrderController@withdrawSubmit')->name('users.withdrawSubmit');
        Route::get('users/records', 'OrderController@records')->name('users.records');

    });
});
Route::get('products/', 'ProductController@index')->name('products.index');



