<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
    }

    public function index()
    {
        // Jika sudah login, redirect ke dashboard
        if ($this->session->get('logged_in')) {
            return redirect()->to('/');
        }

        return view('auth/login');
    }

    public function login()
    {
        // Validasi input
        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Cek login
        $user = $this->userModel->login($username, $password);

        if ($user) {
            // Set session
            $sessionData = [
                'user_id'      => $user['id'],
                'username'     => $user['username'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role'         => $user['role'],
                'logged_in'    => true,
            ];

            $this->session->set($sessionData);

            return redirect()->to('/')->with('success', 'Selamat datang, ' . $user['nama_lengkap'] . '!');
        } else {
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Username atau password salah!');
        }
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/auth')->with('success', 'Anda berhasil logout!');
    }
}