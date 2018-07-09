<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Aapi.authPI routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    $api->post('login', 'LoginController@login');
    $api->post('register', 'RegisterController@register');
    $api->post('logout', 'LoginController@logout');
    $api->post('refresh', 'LoginController@refresh');
    $api->post('me', 'LoginController@me');

    $api->group(['middleware' => 'check.login'], function ($api) {
        $api->get('user', 'UsersController@index');
    });
});