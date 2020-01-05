<?php

require __DIR__ . '/bootstrap.php';

/**
 * @var  $router Lil\Router\RouteProxy;
 */
$router = $app->get(Lil\Router\Interfaces\RouteProxyInterface::class);

//$router->get('/{any}/', 'SampleController@index')->where(['any' => '.*']);
$router->get('/','HomeController@index')->middleware('auth');
$router->get('/login', 'AuthController@loginPage')->middleware('guest');
$router->post('/login', 'AuthController@login')->middleware('guest');
$router->post('/register', 'AuthController@register')->middleware('guest');
$router->get('/register', 'AuthController@registerPage')->middleware('guest');
$router->post('/logout', 'AuthController@logout')->middleware('auth');

$app->handle($request);





