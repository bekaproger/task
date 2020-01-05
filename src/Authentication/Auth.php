<?php

namespace Lil\Authentication;

use Lil\ApplicationInterface;
use Lil\Session\SessionInterface;

class Auth implements AuthManagerInterface
{
    private $app;

    private static $user;

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(ApplicationInterface $application)
    {
        $this->app = $application;
        $this->session = $this->app->get('session');
    }

    public function attempt(array $credentials)
    {
        $class = config('auth.class');
        $user = $this->app->get('doctrine_manager')->getRepository($class)->findOneBy(['email' => $credentials['email']]);

        if ($user && password_verify($credentials['password'], $user->getPassword())) {
            self::$user = $user;
            $this->updateSession();

            return true;
        }

        return false;
    }

    public function user()
    {
        $class = config('auth.class');

        if (!self::$user) {
            $id = $this->session->get('session');

            if ($id) {
                self::$user = $this->app->get('doctrine_manager')->getRepository($class)->find($id);
            }
        }

        return self::$user;
    }

    public function logout()
    {
        self::$user = null;
        $this->session->remove('session');
    }

    public function updateSession()
    {
        $lifetime = config('auth.logged_lifetime', null);
        $this->session->set('session', self::$user->getId(), $lifetime);
    }

    public function register(AuthenticableInterface $user)
    {
        $this->session->set('session', $user->getId());
        self::$user = $user;
    }

    public function setUser($user)
    {
        self::$user = $user;
    }
}
