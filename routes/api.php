<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\v1\api\MovieController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::group(['middleware' => ['api'], 'prefix' => 'v1'], function() {
    Route::post('create-movie/', 'api\v1\MovieController@create');
    Route::patch('update-movie/', 'api\v1\MovieController@update');
    Route::delete('delete-movie/', 'api\v1\MovieController@delete');
    Route::match(array('GET'),'get-movie-id/', 'api\v1\MovieController@show');
    Route::match(array('GET'),'get-all/', 'api\v1\MovieController@getAll');
});
