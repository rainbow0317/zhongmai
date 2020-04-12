<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    $router->get('users', 'UserController@index');

    $router->resource('products', 'ProductController')->names('admin.products')->except('show');
    $router->post('products/{product}', 'ProductController@edit')->name('admin.products.edit');

    $router->post('orders/{order}', 'OrderController@ship')->name('admin.orders.ship');
    $router->post('orders/{order}/refund', 'OrderController@handleRefund')->name('admin.orders.handle_refund');
    $router->resource('orders', 'OrderController')->names('admin.orders')->only('index', 'show');

    $router->resource('shares', 'ShareController')->names('admin.shares')->only('index', 'show');
    $router->resource('withdraws', 'WithdrawController')->names('admin.withdraws')->only('index', 'show');

    $router->resource('selects', SelectController::class);

});
