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

$router->group(['prefix' => 'api/'], function ($router) {
    $router->post('login/','UserController@authenticate');
    $router->post('register/','UserController@register');


    $router->post('todo/','TodoController@store');
    $router->get('todo/', 'TodoController@index');
    $router->get('todo/{id}/', 'TodoController@show');
    $router->put('todo/{id}/', 'TodoController@update');
    $router->delete('todo/{id}/', 'TodoController@destroy');

    $router->post('product-groups/','ProductGroupController@store');
    $router->get('product-groups/', 'ProductGroupController@index');
    $router->get('product-groups/{id}/', 'ProductGroupController@show');
    $router->put('product-groups/{id}/', 'ProductGroupController@update');
    $router->delete('product-groups/{id}/', 'ProductGroupController@destroy');
    $router->post('product-groups/searches','ProductGroupController@searches');
});
