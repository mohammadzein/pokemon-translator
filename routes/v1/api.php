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
    $welcome = '<h1>Welcome to Pokemon Translator</h1>';
    $information = '<h4>for more information please visit </h4>';
    $link = '<a href="https://github.com/mohammadzein/pokemon-translator">pokemon translator github</a>';
    return $welcome . $information . $link;
});

$router->get('pokemon/{name:[A-Za-z]+}', [
    'middleware' => ['throttle:10,60'],
    'uses' => 'PokemonController@get'
]);
