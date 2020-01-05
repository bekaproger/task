<?php

namespace Lil\Authentication;

interface AuthManagerInterface
{
    public function attempt(array $credentials);

    public function user();

    public function updateSession();

    public function setUser($user);

    public function register(AuthenticableInterface $user);

    public function logout();
}
