<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['users'] = $model->findAll();

        return view('admin/user/index', $data);
    }

    public function tambah()
    {
        return view('admin/user/tambah', [
            'validation' => \Config\Services::validation()
        ]);
    }

    public function simpan()
    {
        if (!$this->validate([
            'full_name' => 'required|max_length[255]',
            'email'     => 'required|valid_email|is_unique[user.email]',
            'password'  => 'required|min_length[6]',
            'role'      => 'required|in_list[customer,admin]'
        ])) {
            return redirect()->back()->withInput();
        }

        $model = new UserModel();
        $model->save([
            'full_name'     => $this->request->getPost('full_name'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => $this->request->getPost('role')
        ]);

        return redirect()->to('/admin/users')->with('success', 'User berhasil ditambahkan!');
    }

    public function ubah($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        return view('admin/user/ubah', [
            'user' => $user,
            'validation' => \Config\Services::validation()
        ]);
    }

    public function update($id)
    {
        $model = new UserModel();
        $user = $model->find($id);

        if (!$user) {
            return redirect()->to('/admin/users')->with('error', 'User tidak ditemukan');
        }

        $rules = [
            'full_name' => 'required|max_length[255]',
            'email'     => 'required|valid_email',
            'role'      => 'required|in_list[customer,admin]'
        ];

        if ($this->request->getPost('email') !== $user['email']) {
            $rules['email'] .= '|is_unique[user.email]';
        }

        $password = $this->request->getPost('password');
        if ($password) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email'     => $this->request->getPost('email'),
            'role'      => $this->request->getPost('role')
        ];

        if ($password) {
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        return redirect()->to('/admin/users')->with('success', 'User berhasil diupdate!');
    }

    public function delete($id)
    {
        $model = new UserModel();
        $model->delete($id);

        return redirect()->to('/admin/users')->with('success', 'User telah dihapus.');
    }
}
