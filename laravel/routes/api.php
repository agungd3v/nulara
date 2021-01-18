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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'people'], function() {
    Route::get('/', 'PeopleController@getPeople')->middleware('jwt.verify');
    Route::get('/{id}', 'PeopleController@firstPeople')->middleware('jwt.verify');
    Route::post('/people_save', 'PeopleController@storePeople')->middleware('jwt.verify');
    Route::patch('/people_update/{id}', 'PeopleController@updatePeople')->middleware('jwt.verify');
    Route::delete('/people_delete/{id}', 'PeopleController@deletePeople')->middleware('jwt.verify');
});

Route::group(['prefix' => 'jwt', 'namespace' => 'Api', 'middleware' => ['cors']], function() {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout');

    Route::get('/get_user', 'AuthController@getUser')->middleware('jwt.verify');
});