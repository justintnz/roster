<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Support\Facades\App;

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

$router->get('leave', function () {
    // $onleave = \App\Models\Leave::where('date', '=','2021-03-31')->get();

    $emp = \App\Models\Employee::find(1);
    echo "Hi";
    echo $emp->weekHours('2021-04-01');
});
