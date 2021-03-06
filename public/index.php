<?php

require __DIR__.'/bootstrap.php';

use Lil\Router\Interfaces\RouteProxyInterface;

/**
 * @var $router Lil\Router\RouteProxy;
 */
$router = $app->get(RouteProxyInterface::class);

//$router->get('/{any}/', 'SampleController@index')->where(['any' => '.*']);
$router->get('/', 'HomeController@index');
$router->get('/login', 'AuthController@loginPage')->middleware('guest');
$router->post('/login', 'AuthController@login')->middleware('guest');
$router->post('/register', 'AuthController@register')->middleware('guest');
$router->get('/register', 'AuthController@registerPage')->middleware('guest');
$router->post('/logout', 'AuthController@logout')->middleware('auth');

$router->get('/tasks', 'TaskController@index')->name('tasks.index');

$router->group(['prefix' => 'tasks'], function (RouteProxyInterface $router) {
    $router->get('/create', 'TaskController@create')->name('tasks.create');
    $router->post('/', 'TaskController@store')->name('tasks.store');
    $router->delete('{id}', 'TaskController@delete')->name('tasks.destroy')->middleware(['admin']);
    $router->get('{id}/edit', 'TaskController@edit')->name('tasks.edit')->middleware(['admin']);
    $router->put('{id}', 'TaskController@update')->name('tasks.update')->middleware(['admin']);
    $router->post('{id}/finish', 'TaskController@finish')->name('tasks.finsih')->middleware(['admin']);
    $router->post('{id}/unfinish', 'TaskController@unfinish')->name('tasks.unfinish')->middleware(['admin']);
});

$app->handle($request);
