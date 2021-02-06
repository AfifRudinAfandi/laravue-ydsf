<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('logout', 'Auth\LoginController@logout');

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/{id}/notif', 'API\v1\UserController@getNotifByID');
    Route::get('/user/{id}/notif/unread-count', 'API\v1\UserController@getNotifCount');
    Route::post('/user/{id}/update-profile', 'API\v1\UserController@update');
    Route::post('/user/{id}/update-avatar', 'API\v1\UserController@updateAvatar');
    Route::post('/user/{id}/update-password', 'API\v1\UserController@updatePassword');
    Route::get('/user/{id}/reward', 'API\v1\UserController@getReward');
});


Route::group(['middleware' => 'guest:api,cors'], function () {
    Route::post('login', 'Auth\LoginController@login');

    Route::post('register', 'Auth\RegisterController@register');

    Route::post('phone-auth', 'Auth\RegisterController@phone');
    Route::post('phone-login', 'Auth\LoginController@phoneLogin');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');

    Route::post('email/verify/{user}', 'Auth\VerificationController@verify')->name('verification.verify');
    Route::post('email/resend', 'Auth\VerificationController@resend');

    Route::post('oauth/{driver}', 'Auth\OAuthController@redirectToProvider');
    Route::get('oauth/{driver}/callback', 'Auth\OAuthController@handleProviderCallback')->name('oauth.callback');
});

Route::group(['namespace' => 'API\v1'], function () {
    Route::get('/get/hero-images', 'WebController@getHeroImages');

    Route::group(['prefix' => 'campaigns'], function () {
        Route::get('/location', 'CampaignController@getCampaignLocation');
        Route::get('/categories', 'CampaignController@getAllCategories');
        Route::get('/', 'CampaignController@getAllCampaign');
        Route::get('/feed', 'CampaignController@getHomeCampaign');
        Route::get('/recent', 'CampaignController@getRecentCampaign');
        Route::get('/{id}/id', 'CampaignController@getCampaignById');
        Route::get('/{id}/regional', 'CampaignController@getCampaignByRegionalId');
        Route::get('/{slug}', 'CampaignController@getCampaignBySlug');
        Route::get('/{campaign_id}/progress', 'CampaignController@getProgressByCampaignId');
        Route::get('/progress/{id}', 'CampaignController@getProgressById');
        Route::get('/categories/{id}', 'CampaignController@getCategoryById');
        Route::get('/{campaign_id}/title', 'CampaignController@getCampaignTitle');
    });

    Route::group(['prefix' => 'regionals'], function () {
        Route::get('/', 'RegionalController@getAll');
        Route::get('/{id}', 'RegionalController@getById');
    });

    Route::group(['prefix' => 'blogs'], function () {
        Route::get('/', 'BlogController@getAll');
        Route::get('/{slug}', 'BlogController@getBySlug');
        Route::get('/{id}/recent', 'BlogController@getRecentBlog');
        Route::get('/{id}/id', 'BlogController@getById');
    });

    Route::group(['prefix' => 'donations'], function () {
        Route::get('/', 'DonationController@getAllDonation');
        Route::get('/{id}', 'DonationController@getDonationById');
        Route::get('/campaign/{campaign_id}/', 'DonationController@getByCampaignId');
        Route::get('/user/{user_id}', 'DonationController@getByUserId');
        Route::get('/user/{user_id}/report', 'DonationController@getByUserIdReport');

        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('/create', 'DonationController@create');
            Route::patch('/{id}/update', 'DonationController@update');
            Route::patch('/{uuid}/verification', 'DonationController@verification');
            Route::delete('/{id}/delete', 'DonationController@delete');
        });
    });

    Route::get('/count', 'CounterController@apiCounter')->name('counter.api');
});
