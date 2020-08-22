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
        $router->post('create', 'UserController@save');
        $router->post('edit', 'UserController@save');
        $router->post('delete', 'UserController@delete');
        $router->post('password', 'UserController@updatePassword');
        $router->get('{id}', 'UserController@getById');
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
        $router->post('create', 'PageController@save');
        $router->get('tree', 'PageController@getTree');
    });
});
