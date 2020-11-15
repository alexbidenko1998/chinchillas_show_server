<?php

use App\Http\Middleware\AdminMiddleware;
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

Route::post('/register', 'PassportController@register');
Route::post('/login', 'PassportController@login');

Route::middleware('auth:api')->prefix('user')->group(function () {

  Route::get('/details/{userId}', 'UsersController@details');
  Route::get('/details', 'PassportController@details');
  Route::post('/update', 'PassportController@update');

  Route::get('/search/{page}/{perPage}', 'UsersController@searchUsersPaginate');
  Route::get('/search', 'UsersController@searchUsers');
});

Route::prefix('chinchilla')->group(function () {
    Route::middleware('auth:api')->group(function () {

        Route::post('/create', 'ChinchillasController@addChinchilla');
        Route::post('/color/for-overvalue/{id}', 'ChinchillasController@colorForOvervalue');
        Route::post('/color/{chinchilla_id}', 'ChinchillasController@addColor');
        Route::put('/update/{chinchilla_id}', 'ChinchillasController@updateChinchilla');
        Route::post('/create/status', 'ChinchillasController@createStatus');

        Route::get('/get/{user_id}', 'ChinchillasController@getUserChinchillas');
    });

    Route::get('/details/{chinchilla_id}', 'ChinchillasController@getChinchillaDetails');

    Route::get('/search', 'ChinchillasController@searchChinchillas');
});

Route::middleware('auth:api')->prefix('photo')->group(function () {

  Route::post('/chinchilla/{chinchilla_id}', 'PhotosController@upload');
  Route::delete('/chinchilla/{photo_id}', 'PhotosController@delete');
});

Route::middleware(['auth:api', AdminMiddleware::class])->prefix('admin')->group(function () {

    Route::get('/users', 'AdminController@getUsers');
    Route::put('/user/{id}', 'AdminController@updateUser');

    Route::get('/chinchillas/{page}/{perPage}', 'AdminController@getChinchillas');
    Route::put('/chinchilla/{id}', 'AdminController@updateChinchilla');

    Route::post('/color/comment', 'AdminController@createColorComment');
});

Route::prefix('site')->group(function () {
    Route::get('/statistics', 'SiteController@statistics');
});

// Route::get('/reset/{email}', 'PassportController@resetPassword');
