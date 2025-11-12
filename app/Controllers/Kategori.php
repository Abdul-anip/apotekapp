<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use CodeIgniter\Controller;

class Kategori extends Controller
{
    protected $kategoriModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Daftar Kategori',
            'kategori' => $this->kategoriModel->findAll()
        ];
        return view('kategori/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Kategori'];
        return view('kategori/create', $data);
    }

    public function store()
    {
        $this->kategoriModel->insert([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = $this->kategoriModel->find($id);

        if (!$kategori) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Kategori tidak ditemukan');
        }

        $data = [
            'title'    => 'Edit Kategori',
            'kategori' => $kategori
        ];

        return view('kategori/edit', $data);
    }

    public function update(int $id)
    {
        $this->kategoriModel->update($id, [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        return redirect()->to('/kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->kategoriModel->delete($id);
        return redirect()->to('/kategori')->with('success', 'Kategori berhasil dihapus.');
    }

}
