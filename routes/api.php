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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/* Version 1 */
Route::group(['prefix' => '/v1'], function () {

    /* User */
    Route::group(['prefix' => '/users'], function () {
        Route::post('/register', 'UserController@register');
        Route::post('/login', 'UserController@login');
        Route::put('/password', 'UserController@changePassword');

        /* Authentication Required */
        Route::group(['middleware' => 'auth:api'], function () {
            Route::delete('/', 'UserController@delete');
            Route::delete('/{username}', 'UserController@destroy');
        });
    });

    /* Event */
    Route::group(['prefix' => '/events', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'EventController@index');
        Route::post('/', 'EventController@create');
        Route::put('/{id}', 'EventController@edit');
        Route::get('/{id}/tags', 'EventController@showEventTags');
        Route::post('/{id}/tags', 'EventController@tag');
        Route::delete('/{id}', 'EventController@destroy');
    });

    /* Tag */
    Route::group(['prefix' => '/tags', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'TagController@index');
        Route::post('/', 'TagController@create');
        Route::put('/{id}', 'TagController@edit');
        Route::get('/{id}/events', 'TagController@showTagEvents');
        Route::delete('/{id}', 'TagController@destroy');
    });

    /* Log */
    Route::group(['prefix' => '/logs', 'middleware' => 'auth:api'], function () {
        Route::get('/', 'LogController@index');
    });
});
