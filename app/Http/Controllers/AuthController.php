<?php

namespace App\Http\Controllers;

use App\Http\Validation\LoginValidator;
use App\Http\Validation\RegistrationValidator;
use App\Model\User;
use Lil\Authentication\AuthManagerInterface;
use Lil\Http\AbstractController;
use Lil\Http\Request;
use Lil\Http\ValidationException;

class AuthController extends AbstractController
{
    private $auth;

    public function __construct(AuthManagerInterface $authManager)
    {
        $this->auth = $authManager;
    }

    public function loginPage()
    {
        return view('login');
    }

    public function login(Request $request, LoginValidator $validator)
    {
        $this->validate($request, $validator);

        $credentials = ['email' => $request->request->get('email'), 'password' => $request->request->get('password')];
        if ($this->auth->attempt($credentials)) {
            return redirect('/');
        }

        $request->setValidationErrors(['email' => 'User not found!']);

        return back();
    }

    public function registerPage()
    {
        return view('register');
    }

    public function register(Request $request, RegistrationValidator $validator)
    {
        $this->validate($request, $validator);

        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $name = $request->request->get('name');

        $user = $this->getManager()->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            $request->setValidationErrors(['email' => 'User with this email already exists']);
            throw new ValidationException();
        }

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
        $user->setIsAdmin(true);
        $this->getManager()->persist($user);

        $this->getManager()->flush();

        $this->auth->register($user);

        return redirect('/');
    }

    public function logout()
    {
        $this->auth->logout();

        return redirect('/login');
    }
}
