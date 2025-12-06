<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }
    public function admin()
    {
        return view('admin/layout');
    }

    public function loginAuth()
    {
        $session = session();
        $userModel = new UserModel();

        $full_name = $this->request->getPost('full_name');
        $password_hash = $this->request->getPost('password_hash');

        $user = $userModel->where('full_name', $full_name)
            ->orWhere('email', $full_name)
            ->first();

        if ($user) {

            if (password_verify($password_hash, $user['password_hash'])) {

                $session->set([
                    'user_id' => $user['user_id'],
                    'full_name' => $user['full_name'],
                    'email' => $user['email'],
                    'role' => $user['role'],
                    'isLoggedIn' => true
                ]);

                if ($user['role'] === 'admin') {
                    return redirect()->to('admin/index');
                } else {
                    return redirect()->to('home');
                }
            } else {
                return redirect()->back()->with('error', 'Password Salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Akun Tidak Ditemukan!');
        }
    }
    public function register()
    {
        return view('auth/register');
    }

    public function registerAuth()
    {
        $userModel = new UserModel();

        $full_name = $this->request->getPost('full_name');
        $email    = $this->request->getPost('email');
        $password_hash = $this->request->getPost('password_hash');
        $confirm  = $this->request->getPost('confirm');

        if ($password_hash !== $confirm) {
            return redirect()->back()->with('error', 'Password tidak sama!');
        }

        if ($userModel->where('email', $email)->orWhere('full_name', $full_name)->first()) {
            return redirect()->back()->with('error', 'Email atau full_name sudah digunakan!');
        }

        $userModel->insert([
            'full_name' => $full_name,
            'email'    => $email,
            'password_hash' => password_hash($password_hash, PASSWORD_DEFAULT),
            'role' => 'customer',
        ]);

        return redirect()->to('/login')->with('success', 'Register berhasil! Silahkan login.');
    }

    public function logout()
    {
        $session = session();

        $session->remove(['user_id', 'full_name', 'email', 'isLoggedIn']);

        return redirect()->to(base_url('/home'))->with('success', 'Anda berhasil logout.');
    }
}