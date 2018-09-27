<?php

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

$router->post('auth/login', 'AuthsController@login');
$router->post('auth/register', 'AuthsController@register');

/**
 * Routes for resource auth
 */
$router->group(['prefix' => 'mandiri','middleware' => 'jwt.auth'],function() use($router) {
	$router->get('warga/profil', 'WargasController@profil');
	$router->get('warga/bantuan', 'WargasController@bantuan');
	$router->get('warga/layanan', 'WargasController@layanan');
	$router->post('warga/lapor', 'WargasController@lapor');
	//$router->get('auth', 'AuthsController@all');
	//$router->get('auth/{id}', 'AuthsController@get');
	//$router->post('auth', 'AuthsController@add');
	//$router->put('auth/{id}', 'AuthsController@put');
	//$router->delete('auth/{id}', 'AuthsController@remove');
});

