<?php

require_once __DIR__.'/../vendor/autoload.php';

$app = new Laravel\Lumen\Application(
    realpath(__DIR__.'/../')
);

$app->get('/', function () {
    return view('home');
});

$app->get('/mixedContent', function () {
    return view('mixedContent');
});

$app->get('/noMixedContent', function () {
    return view('noMixedContent');
});

$app->get('/ignore', function () {
    return view('ignore');
});

$app->get('/userAgent', function () {
    file_put_contents( dirname(__DIR__, 2).'/temp/agent.txt', $_SERVER['HTTP_USER_AGENT']);
    return view('userAgent');
});

$app->get('noResponse', function () {
    die();
});

$app->get('redirect', function () {
    return redirect('/noMixedContent');
});

$app->get('booted', function () {
    return 'app has booted';
});

$app->run();
