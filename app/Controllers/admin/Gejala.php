<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GejalaModel;

class Gejala extends BaseController
{
    protected $gejalaModel;
    protected $session;

    public function __construct()
    {
        $this->gejalaModel = new GejalaModel();
        $this->session = session();
        
        if ($this->session->get('role') !== 'pemilik') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get gejala dengan jumlah aturan
        $gejala = $db->table('gejala')
            ->select('gejala.*, COUNT(aturan.id) as jumlah_aturan')
            ->join('aturan', 'aturan.id_gejala = gejala.id', 'left')
            ->groupBy('gejala.id')
            ->orderBy('gejala.kode_gejala', 'ASC')
            ->get()
            ->getResultArray();

        // Statistik
        $totalGejala = $this->gejalaModel->countAll();
        $gejalaDigunakan = $db->table('gejala')
            ->select('COUNT(DISTINCT gejala.id) as total')
            ->join('aturan', 'aturan.id_gejala = gejala.id')
            ->get()
            ->getRow()
            ->total ?? 0;

        $data = [
            'title'  => 'Manajemen Gejala',
            'gejala' => $gejala,
            'stats'  => [
                'total'      => $totalGejala,
                'digunakan'  => $gejalaDigunakan,
                'tidak_digunakan' => $totalGejala - $gejalaDigunakan
            ]
        ];

        return view('admin/gejala/index', $data);
    }

    public function create()
    {
        // Generate kode otomatis
        $lastGejala = $this->gejalaModel->orderBy('id', 'DESC')->first();
        $kodeOtomatis = 'G001';
        
        if ($lastGejala) {
            $lastKode = $lastGejala['kode_gejala'];
            $number = (int)substr($lastKode, 1);
            $newNumber = $number + 1;
            $kodeOtomatis = 'G' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        $data = [
            'title'         => 'Tambah Gejala Baru',
            'kode_otomatis' => $kodeOtomatis
        ];

        return view('admin/gejala/create', $data);
    }

    public function store()
    {
        $rules = [
            'kode_gejala' => 'required|min_length[3]|max_length[10]|is_unique[gejala.kode_gejala]',
            'nama_gejala' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kode_gejala' => strtoupper($this->request->getPost('kode_gejala')),
            'nama_gejala' => $this->request->getPost('nama_gejala'),
            'created_at'  => date('Y-m-d H:i:s')
        ];

        if ($this->gejalaModel->insert($data)) {
            return redirect()->to('/admin/gejala')->with('success', 'Gejala berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan gejala!');
        }
    }

    public function edit($id)
    {
        $gejala = $this->gejalaModel->find($id);
        
        if (!$gejala) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gejala tidak ditemukan');
        }

        $data = [
            'title'  => 'Edit Gejala',
            'gejala' => $gejala
        ];

        return view('admin/gejala/edit', $data);
    }

    public function update($id)
    {
        $gejala = $this->gejalaModel->find($id);
        
        if (!$gejala) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gejala tidak ditemukan');
        }

        $rules = [
            'kode_gejala' => "required|min_length[3]|max_length[10]|is_unique[gejala.kode_gejala,id,{$id}]",
            'nama_gejala' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'kode_gejala' => strtoupper($this->request->getPost('kode_gejala')),
            'nama_gejala' => $this->request->getPost('nama_gejala'),
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        if ($this->gejalaModel->update($id, $data)) {
            return redirect()->to('/admin/gejala')->with('success', 'Gejala berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui gejala!');
        }
    }

    public function delete($id)
    {
        $gejala = $this->gejalaModel->find($id);
        
        if (!$gejala) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Gejala tidak ditemukan');
        }

        // Cek apakah gejala digunakan dalam aturan
        $db = \Config\Database::connect();
        $countAturan = $db->table('aturan')->where('id_gejala', $id)->countAllResults();

        if ($countAturan > 0) {
            // Hapus aturan terkait terlebih dahulu
            $db->transStart();
            $db->table('aturan')->where('id_gejala', $id)->delete();
            $this->gejalaModel->delete($id);
            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->to('/admin/gejala')->with('error', 'Gagal menghapus gejala!');
            }

            return redirect()->to('/admin/gejala')->with('success', "Gejala dan {$countAturan} aturan terkait berhasil dihapus!");
        } else {
            if ($this->gejalaModel->delete($id)) {
                return redirect()->to('/admin/gejala')->with('success', 'Gejala berhasil dihapus!');
            } else {
                return redirect()->to('/admin/gejala')->with('error', 'Gagal menghapus gejala!');
            }
        }
    }

    public function generateKode()
    {
        $lastGejala = $this->gejalaModel->orderBy('id', 'DESC')->first();
        $kodeOtomatis = 'G001';
        
        if ($lastGejala) {
            $lastKode = $lastGejala['kode_gejala'];
            $number = (int)substr($lastKode, 1);
            $newNumber = $number + 1;
            $kodeOtomatis = 'G' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        }

        return $this->response->setJSON(['kode' => $kodeOtomatis]);
    }
}