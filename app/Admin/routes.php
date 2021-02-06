<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('regionals', RegionalController::class);
    $router->resource('donations', DonationController::class);
    $router->resource('campaigns/all', CampaignController::class);
    $router->resource('campaigns/category', CampaignCategoryController::class);
    $router->resource('campaigns/progress', CampaignProgressController::class);
    $router->resource('blogs', BlogController::class);
    $router->resource('users', UserController::class);
    $router->resource('rewards', RewardController::class);
    $router->resource('payment-logs', PaymentController::class);
    $router->resource('hero-images', HeroImageController::class);
});
