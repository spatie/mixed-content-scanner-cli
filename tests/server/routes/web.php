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

$router->get('/', function () {
    return view('home');
});

$router->get('/mixedContent', function () {
    return view('mixedContent');
});

$router->get('/noMixedContent', function () {
    return view('noMixedContent');
});

$router->get('/ignore', function () {
    return view('ignore');
});

$router->get('/userAgent', function () {
    file_put_contents(dirname(__DIR__, 2).'/temp/agent.txt', $_SERVER['HTTP_USER_AGENT']);

    return view('userAgent');
});

$router->get('noResponse', function () {
    exit();
});

$router->get('redirect', function () {
    return redirect('/noMixedContent');
});

$router->get('booted', function () {
    return 'app has booted';
});
