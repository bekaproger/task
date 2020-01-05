<?php

use Lil\Application;

if (!function_exists('app')) {
    function app()
    {
        return Application::getInstance();
    }
}

if (!function_exists('config')) {
    function config(string $config, $default = null)
    {
        $exploded = explode('.', $config);
        if (empty($exploded)) {
            return null;
        }

        $configs = require app()->getBaseDir().'/config/'.$exploded[0].'.php';

        unset($exploded[0]);

        foreach ($exploded as $path) {
            if (array_key_exists($path, $configs)) {
                $configs = $configs[$path];
            } else {
                return $default;
            }
        }

        return $configs;
    }
}

if (!function_exists('env')) {
    function env(string $name, $default = null)
    {
        if (array_key_exists($name, $_ENV)) {
            return $_ENV[$name];
        } else {
            return $default;
        }
    }
}

if (!function_exists('lil_str_random')) {
    function lil_str_random(int $length = 16)
    {
        $string = '';

        while (($len = strlen($string)) < $length) {
            $size = $length - $len;
            $bytes = random_bytes($size);
            $string .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }

        return $string;
    }
}

if (!function_exists('view')) {
    function view($name, array $params = [])
    {
        ob_start();

        $filename = app()->getBaseDir().'/views/'.str_replace('.', '/', $name).'.php';
        require  $filename;
        unset($filename);

        extract($params);

        $view = ob_get_contents();

        ob_end_clean();

        return new \Symfony\Component\HttpFoundation\Response($view);
    }
}

if (! function_exists('e')) {
    function e($val) {
        echo htmlspecialchars($val);
    }
}

if (!function_exists('auth')) {
    function auth(): \Lil\Authentication\AuthManagerInterface
    {
        return app()->get('auth');
    }
}

if (!function_exists('redirect')) {
    function redirect($route, int $status = 302): \Symfony\Component\HttpFoundation\RedirectResponse
    {
        return new \Symfony\Component\HttpFoundation\RedirectResponse($route, $status);
    }
}

if (!function_exists('back')) {
    function back($route = null, int $status = 302)
    {
        if (!$route) {
            $route = app()->get('session')->get('previous_url', null) ?? app()->get('request')->path();
        }

        return redirect($route, $status);
    }
}

if (!function_exists('session')) {
    function session(): \Lil\Session\SessionInterface
    {
        return app()->get('session');
    }
}

if (!function_exists('dispatch')) {
    function dispatch(string $event, ...$params)
    {
        app()->make($event)->handle($params);
    }
}

if (!function_exists('request')) {
    function request(): \Lil\Http\Request
    {
        return app()->get('request');
    }
}
