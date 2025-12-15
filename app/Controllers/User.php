<?php

namespace App\Controllers;

use App\Models\UserModel;

class User extends BaseController
{
    protected $userModel;
    protected $session;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->session = session();
        
        if ($this->session->get('role') !== 'pemilik') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }

    public function index()
    {
        $users = $this->userModel->findAll();
        
        $data = [
            'title' => 'Manajemen User',
            'users' => $users
        ];
        
        return view('user/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User Baru'
        ];
        
        return view('user/create', $data);
    }

    public function store()
    {
        $rules = [
            'username'     => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'password'     => 'required|min_length[6]',
            'nama_lengkap' => 'required|max_length[150]',
            'role'         => 'required|in_list[pemilik,kasir]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'     => $this->request->getPost('username'),
            'password'     => $this->request->getPost('password'), // Akan di-hash otomatis di model
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role'         => $this->request->getPost('role'),
            'is_active'    => 1,
        ];

        if ($this->userModel->insert($data)) {
            return redirect()->to('/user')->with('success', 'User berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan user!');
        }
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        $data = [
            'title' => 'Edit User',
            'user'  => $user
        ];
        
        return view('user/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        $rules = [
            'username'     => "required|min_length[3]|max_length[100]|is_unique[users.username,id,{$id}]",
            'nama_lengkap' => 'required|max_length[150]',
            'role'         => 'required|in_list[pemilik,kasir]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[6]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username'     => $this->request->getPost('username'),
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'role'         => $this->request->getPost('role'),
            'is_active'    => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        if ($this->userModel->update($id, $data)) {
            return redirect()->to('/user')->with('success', 'User berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui user!');
        }
    }

    public function delete($id)
    {
        if ($id == $this->session->get('user_id')) {
            return redirect()->to('/user')->with('error', 'Anda tidak dapat menghapus akun sendiri!');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        if ($this->userModel->delete($id)) {
            return redirect()->to('/user')->with('success', 'User berhasil dihapus!');
        } else {
            return redirect()->to('/user')->with('error', 'Gagal menghapus user!');
        }
    }

    public function toggleStatus($id)
    {
        if ($id == $this->session->get('user_id')) {
            return redirect()->to('/user')->with('error', 'Anda tidak dapat menonaktifkan akun sendiri!');
        }

        $user = $this->userModel->find($id);
        
        if (!$user) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('User tidak ditemukan');
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        
        if ($this->userModel->update($id, ['is_active' => $newStatus])) {
            $message = $newStatus ? 'User berhasil diaktifkan!' : 'User berhasil dinonaktifkan!';
            return redirect()->to('/user')->with('success', $message);
        } else {
            return redirect()->to('/user')->with('error', 'Gagal mengubah status user!');
        }
    }
}