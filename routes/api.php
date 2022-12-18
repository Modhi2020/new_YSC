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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login' , 'Api\User_Controller@login');

Route::group(
    [
        'middleware' => [  'checkJwtToken' ]
    ], function (){
      

    Route::post('check_login' , 'Api\User_Controller@check_login');
Route::post('/get_user' , 'Api\User_Controller@get_item');
Route::post('/get_users' , 'Api\User_Controller@get_all');
Route::post('/search_user' , 'Api\User_Controller@search');

    
});

Route::get('/mb', function () {
    return "ok";
});
