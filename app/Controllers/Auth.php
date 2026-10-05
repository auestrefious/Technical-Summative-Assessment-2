<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function showLogin()
    {
        if (session()->get('user_id') !== null) {
            return redirect()->to(site_url('tasks'));
        }

        return view('auth/login');
    }

    public function login()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $username = is_string($username) ? trim($username) : '';
        $password = is_string($password) ? $password : '';

        if (! $this->validateData(
            ['username' => $username, 'password' => $password],
            ['username' => 'required', 'password' => 'required'],
        )) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Enter your username and password.');
        }

        $user = (new UserModel())->where('username', $username)->first();

        if ($user === null || ! is_string($user['password'] ?? null)
            || ! password_verify($password, $user['password'])) {
            return redirect()->to(site_url('login'))
                ->with('error', 'Invalid username or password.');
        }

        session()->regenerate(true);
        session()->set([
            'user_id' => (int) $user['id'],
            'username' => $user['username'],
        ]);

        return redirect()->to(site_url('tasks'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('login'));
    }
}
