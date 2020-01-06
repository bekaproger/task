<?php

namespace Lil\Session;

use Lil\Http\Request;
use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NativeFileSessionHandler;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

class Session extends SymfonySession implements SessionInterface
{
    private static $instance;

    public function get(string $name, $default = null)
    {
        if ($val = parent::get($name)) {
            if ($val['lifetime'] && $val['lifetime'] <= time()) {
                $this->remove($name);

                return $default;
            }

            return $val['value'];
        }

        return $default;
    }

    public function set(string $name, $value, int $lifetime = null): void
    {
        $value = ['value' => $value, 'lifetime' => $lifetime ? time() + $lifetime : null];

        parent::set($name, $value);
    }

    public static function create()
    {
        if (!self::$instance) {
            $sessionStorage = new NativeSessionStorage([], new NativeFileSessionHandler());
            self::$instance = new Session($sessionStorage);
        }

        return self::$instance;
    }

    public function setPreviousUrl(Request $request): void
    {
        $this->set('_previous_url', $request->fullUrl());
    }

    public function getPreviousUrl(): string
    {
        return $this->get('_previous_url');
    }
}
