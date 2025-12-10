<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenyakitModel;

class Penyakit extends BaseController
{
    protected $penyakitModel;
    protected $session;

    public function __construct()
    {
        $this->penyakitModel = new PenyakitModel();
        $this->session = session();
        
        // Cek apakah user adalah pemilik
        if ($this->session->get('role') !== 'pemilik') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }

    public function index()
    {
        $penyakit = $this->penyakitModel->getPenyakitWithAturanCount();
        $stats = $this->penyakitModel->getStatistik();

        $data = [
            'title'    => 'Manajemen Penyakit',
            'penyakit' => $penyakit,
            'stats'    => $stats
        ];

        return view('admin/penyakit/index', $data);
    }

    public function create()
    {
        // Generate kode otomatis
        $kodeOtomatis = $this->penyakitModel->generateKodePenyakit();

        $data = [
            'title'         => 'Tambah Penyakit Baru',
            'kode_otomatis' => $kodeOtomatis
        ];

        return view('admin/penyakit/create', $data);
    }

    public function store()
    {
        // Validasi
        $rules = [
            'kode_penyakit' => 'required|min_length[3]|max_length[10]|is_unique[penyakit.kode_penyakit]',
            'nama_penyakit' => 'required|min_length[3]|max_length[255]',
            'deskripsi'     => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Simpan
        $data = [
            'kode_penyakit' => strtoupper($this->request->getPost('kode_penyakit')),
            'nama_penyakit' => $this->request->getPost('nama_penyakit'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'created_at'    => date('Y-m-d H:i:s')
        ];

        if ($this->penyakitModel->insert($data)) {
            return redirect()->to('/admin/penyakit')->with('success', 'Penyakit berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan penyakit!');
        }
    }

    public function edit($id)
    {
        $penyakit = $this->penyakitModel->getPenyakitWithAturan($id);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        $data = [
            'title'    => 'Edit Penyakit',
            'penyakit' => $penyakit
        ];

        return view('admin/penyakit/edit', $data);
    }

    public function update($id)
    {
        $penyakit = $this->penyakitModel->find($id);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        // Validasi
        $rules = [
            'kode_penyakit' => "required|min_length[3]|max_length[10]|is_unique[penyakit.kode_penyakit,id,{$id}]",
            'nama_penyakit' => 'required|min_length[3]|max_length[255]',
            'deskripsi'     => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update
        $data = [
            'kode_penyakit' => strtoupper($this->request->getPost('kode_penyakit')),
            'nama_penyakit' => $this->request->getPost('nama_penyakit'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'updated_at'    => date('Y-m-d H:i:s')
        ];

        if ($this->penyakitModel->update($id, $data)) {
            return redirect()->to('/admin/penyakit')->with('success', 'Penyakit berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui penyakit!');
        }
    }

    public function delete($id)
    {
        $penyakit = $this->penyakitModel->find($id);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        // Cek apakah penyakit punya aturan
        $hasAturan = $this->penyakitModel->hasAturan($id);

        if ($hasAturan) {
            // Konfirmasi sudah dilakukan di frontend
            // Hapus penyakit beserta aturan terkait
            if ($this->penyakitModel->deletePenyakitWithAturan($id)) {
                return redirect()->to('/admin/penyakit')->with('success', 'Penyakit dan aturan terkait berhasil dihapus!');
            } else {
                return redirect()->to('/admin/penyakit')->with('error', 'Gagal menghapus penyakit!');
            }
        } else {
            // Hapus langsung
            if ($this->penyakitModel->delete($id)) {
                return redirect()->to('/admin/penyakit')->with('success', 'Penyakit berhasil dihapus!');
            } else {
                return redirect()->to('/admin/penyakit')->with('error', 'Gagal menghapus penyakit!');
            }
        }
    }

    /**
     * View detail penyakit dengan aturan
     */
    public function detail($id)
    {
        $penyakit = $this->penyakitModel->getPenyakitWithAturan($id);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        $data = [
            'title'    => 'Detail Penyakit - ' . $penyakit['nama_penyakit'],
            'penyakit' => $penyakit
        ];

        return view('admin/penyakit/detail', $data);
    }
}