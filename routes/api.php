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

Route::post('/register', 'PassportController@register');
Route::post('/login', 'PassportController@login');

Route::middleware('auth:api')->prefix('user')->group(function () {

  Route::get('/details/{userId}', 'UsersController@details');
  Route::get('/details', 'PassportController@details');

  Route::get('/search/{page}/{perPage}', 'UsersController@searchUsersPaginate');
  Route::get('/search', 'UsersController@searchUsers');
});

Route::middleware('auth:api')->prefix('chinchilla')->group(function () {

  Route::post('/create', 'ChinchillasController@addChinchilla');
  Route::post('/color/{chinchilla_id}', 'ChinchillasController@addColor');

  Route::get('/details/{chinchilla_id}', 'ChinchillasController@getChinchillaDetails');
  Route::get('/get/{user_id}', 'ChinchillasController@getUserChinchillas');

  Route::get('/search', 'ChinchillasController@searchChinchillas');
});

Route::middleware('auth:api')->prefix('photo')->group(function () {

  Route::post('/chinchilla/{chinchilla_id}', 'PhotosController@upload');
  Route::delete('/chinchilla/{photo_id}', 'PhotosController@delete');
});
