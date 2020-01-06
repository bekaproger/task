<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

$services = require __DIR__.'/services.php';

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__).'/.env.local');

$app = new \Lil\Application(dirname(__DIR__), $services);

$request = \Lil\Http\Request::createFromGlobals();

$app->set(Lil\Http\Request::class, $request);
$app->set('request', $request);
