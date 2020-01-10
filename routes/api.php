<?php

use Illuminate\Http\Request;

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

Route::group([
    'prefix' => 'v1',
    'namespace' => 'Api',
    'middleware' => 'throttle:' . config('api.rate_limits.access')
], function () {
    Route::group([
        'prefix' => 'admin',
        'namespace' => 'Admin'
    ], function () {
        Route::group(['namespace' => 'Article'], function () {
            Route::resource('articles', 'ArticleController')->only(['index', 'store', 'show', 'update', 'destroy']);

            Route::resource('article_categories', 'ArticleCategoryController')->only(['index', 'store', 'show', 'update', 'destroy']);
            Route::get('article_category_trees', 'ArticleCategoryController@showTree');
        });


        Route::group(['namespace' => 'Admin'], function () {
            Route::resource('admins', 'AdminController')->only(['show']);
            Route::post('admin/me', 'AdminController@me');
        });

        Route::group(['namespace' => 'Image'], function () {
            Route::post('image', 'ImageController@store');
        });

        Route::group(['namespace' => 'Auth', 'prefix' => 'auth'],function () {
            Route::post('authorization', 'AuthorizationController@store');
            Route::put('authorization', 'AuthorizationController@update');
            Route::delete('authorization', 'AuthorizationController@destroy');
        });
    });



    Route::group(['namespace'=>'Frontend'],function(){

        Route::group(['middleware'=>'auth'],function(){
            Route::group(['namespace' => 'Goal'], function () {
                Route::resource('goals', 'GoalController');
                Route::resource('goal_categories', 'GoalCategoryController');
                Route::get('goal_category_trees', 'GoalCategoryController@showTree');
            });
        });



        Route::group(['namespace' => 'Auth', 'prefix' => 'auth'],function () {
            Route::post('authorization', 'AuthorizationController@store');
            Route::put('authorization', 'AuthorizationController@update');
            Route::delete('authorization', 'AuthorizationController@destroy');
        });

    });
});
