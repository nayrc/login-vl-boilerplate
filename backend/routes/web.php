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


$router->group(['prefix' => 'auth'], function () use ($router){
    $router->post('/login', 'AppAuthController@login');
    $router->post('/forgotPassword', 'AppAuthController@forgotPassword');
    $router->post('/checkCodeOtp', 'AppAuthController@checkCodeOtp');
    $router->post('/resetPassword', 'AppAuthController@resetPassword');
});

$router->group(['middleware' => 'auth'], function () use($router){     
    $router->group(['prefix' => 'auth'], function () use ($router){
        $router->post('/logout', 'AppAuthController@logout');
    });

    $router->group(['prefix' => 'profile'], function () use ($router){
        $router->get('/{id}', 'AppHomeController@profile');
    }); 
    $router->get('/dashboard', 'AppHomeController@index');
});

