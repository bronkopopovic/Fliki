<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group([
    'prefix' => 'api'
], function($router){

    // auth routes
    $router->group([
        'prefix' => 'auth'
    ], function ($router) {
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->post('me', 'AuthController@me');
    });

    // single user routes
    $router->group([
        'prefix' => 'user'
    ], function ($router) {
        $router->get('{id}', 'UserController@getById');
        $router->post('/', 'UserController@create');
        $router->put('{id}', 'UserController@save');
        $router->delete('{id}', 'UserController@delete');
        $router->post('{id}/password', 'UserController@updatePassword');
    });

    // user collection routes
    $router->group([
        'prefix' => 'users'
    ], function ($router) {
        $router->get('/', 'UserController@getAll');
    });

    // page routes
    $router->group([
        'prefix' => 'page'
    ], function ($router) {
        $router->post('/', 'PageController@save');
        $router->get('/', 'PageController@get');
        $router->get('tree', 'PageController@getTree');
    });
});
