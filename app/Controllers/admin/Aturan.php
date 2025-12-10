<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\GejalaModel;
use App\Models\PenyakitModel;
use App\Models\AturanModel;

class Aturan extends BaseController
{
    protected $aturanModel;
    protected $gejalaModel;
    protected $penyakitModel;
    protected $session;

    public function __construct()
    {
        $this->aturanModel = new AturanModel();
        $this->gejalaModel = new GejalaModel();
        $this->penyakitModel = new PenyakitModel();
        $this->session = session();
        
        // Cek apakah user adalah pemilik
        if ($this->session->get('role') !== 'pemilik') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }

    public function index()
    {
        // Ambil semua aturan dengan join
        $aturan = $this->aturanModel
            ->select('aturan.*, penyakit.nama_penyakit, penyakit.kode_penyakit, gejala.nama_gejala, gejala.kode_gejala')
            ->join('penyakit', 'penyakit.id = aturan.id_penyakit')
            ->join('gejala', 'gejala.id = aturan.id_gejala')
            ->orderBy('penyakit.nama_penyakit', 'ASC')
            ->orderBy('aturan.cf_pakar', 'DESC')
            ->findAll();

        // Hitung statistik
        $totalAturan = count($aturan);
        $totalPenyakit = $this->penyakitModel->countAll();
        $totalGejala = $this->gejalaModel->countAll();
        
        // Penyakit tanpa aturan
        $penyakitTanpaAturan = $this->penyakitModel
            ->select('penyakit.*')
            ->join('aturan', 'aturan.id_penyakit = penyakit.id', 'left')
            ->where('aturan.id IS NULL')
            ->findAll();

        $data = [
            'title' => 'Manajemen Aturan Knowledge Base',
            'aturan' => $aturan,
            'stats' => [
                'total_aturan' => $totalAturan,
                'total_penyakit' => $totalPenyakit,
                'total_gejala' => $totalGejala,
                'coverage' => $totalPenyakit > 0 ? round(($totalPenyakit - count($penyakitTanpaAturan)) / $totalPenyakit * 100, 1) : 0
            ],
            'penyakit_tanpa_aturan' => $penyakitTanpaAturan
        ];

        return view('admin/aturan/index', $data);
    }

    public function create()
    {
        // Tidak diperlukan lagi karena menggunakan modal
        return redirect()->to('/admin/aturan');
    }

    public function store()
    {
        // Validasi
        $rules = [
            'id_penyakit' => 'required|integer',
            'id_gejala'   => 'required|integer',
            'cf_pakar'    => 'required|decimal|greater_than[0]|less_than_equal_to[1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_penyakit = $this->request->getPost('id_penyakit');
        $id_gejala   = $this->request->getPost('id_gejala');
        $cf_pakar    = $this->request->getPost('cf_pakar');

        // Cek duplikasi
        $existing = $this->aturanModel
            ->where('id_penyakit', $id_penyakit)
            ->where('id_gejala', $id_gejala)
            ->first();

        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Aturan untuk kombinasi penyakit dan gejala ini sudah ada!');
        }

        // Simpan
        $data = [
            'id_penyakit' => $id_penyakit,
            'id_gejala'   => $id_gejala,
            'cf_pakar'    => $cf_pakar,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        if ($this->aturanModel->insert($data)) {
            return redirect()->to('/admin/aturan')->with('success', 'Aturan berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan aturan!');
        }
    }

    public function edit($id)
    {
        // Tidak diperlukan lagi karena menggunakan modal
        return redirect()->to('/admin/aturan');
    }

    public function update($id)
    {
        $aturan = $this->aturanModel->find($id);
        
        if (!$aturan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Aturan tidak ditemukan');
        }

        // Validasi
        $rules = [
            'id_penyakit' => 'required|integer',
            'id_gejala'   => 'required|integer',
            'cf_pakar'    => 'required|decimal|greater_than[0]|less_than_equal_to[1]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id_penyakit = $this->request->getPost('id_penyakit');
        $id_gejala   = $this->request->getPost('id_gejala');
        $cf_pakar    = $this->request->getPost('cf_pakar');

        // Cek duplikasi (kecuali diri sendiri)
        $existing = $this->aturanModel
            ->where('id_penyakit', $id_penyakit)
            ->where('id_gejala', $id_gejala)
            ->where('id !=', $id)
            ->first();

        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Aturan untuk kombinasi penyakit dan gejala ini sudah ada!');
        }

        // Update
        $data = [
            'id_penyakit' => $id_penyakit,
            'id_gejala'   => $id_gejala,
            'cf_pakar'    => $cf_pakar,
            'updated_at'  => date('Y-m-d H:i:s')
        ];

        if ($this->aturanModel->update($id, $data)) {
            return redirect()->to('/admin/aturan')->with('success', 'Aturan berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui aturan!');
        }
    }

    public function delete($id)
    {
        $aturan = $this->aturanModel->find($id);
        
        if (!$aturan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Aturan tidak ditemukan');
        }

        if ($this->aturanModel->delete($id)) {
            return redirect()->to('/admin/aturan')->with('success', 'Aturan berhasil dihapus!');
        } else {
            return redirect()->to('/admin/aturan')->with('error', 'Gagal menghapus aturan!');
        }
    }

    // Bulk Add - Tambah multiple gejala untuk satu penyakit sekaligus
    public function bulkCreate($id_penyakit)
    {
        $penyakit = $this->penyakitModel->find($id_penyakit);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        // Ambil gejala yang belum ada aturannya untuk penyakit ini
        $gejalaExisting = $this->aturanModel
            ->select('id_gejala')
            ->where('id_penyakit', $id_penyakit)
            ->findColumn('id_gejala');

        $gejalaAvailable = $this->gejalaModel
            ->whereNotIn('id', $gejalaExisting ?: [0])
            ->orderBy('kode_gejala', 'ASC')
            ->findAll();

        $data = [
            'title' => 'Tambah Aturan Massal - ' . $penyakit['nama_penyakit'],
            'penyakit' => $penyakit,
            'gejala' => $gejalaAvailable
        ];

        return view('admin/aturan/bulk_create', $data);
    }

    public function bulkStore()
    {
        $id_penyakit = $this->request->getPost('id_penyakit');
        $gejala_ids  = $this->request->getPost('gejala_id'); // Array
        $cf_values   = $this->request->getPost('cf_pakar');  // Array

        if (empty($gejala_ids) || empty($cf_values)) {
            return redirect()->back()->with('error', 'Pilih minimal 1 gejala dengan CF!');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $inserted = 0;
        foreach ($gejala_ids as $index => $id_gejala) {
            $cf = $cf_values[$index] ?? 0;
            
            if ($cf > 0 && $cf <= 1) {
                $data = [
                    'id_penyakit' => $id_penyakit,
                    'id_gejala'   => $id_gejala,
                    'cf_pakar'    => $cf,
                    'created_at'  => date('Y-m-d H:i:s')
                ];
                
                $this->aturanModel->insert($data);
                $inserted++;
            }
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Gagal menyimpan aturan!');
        }

        return redirect()->to('/admin/aturan')->with('success', "Berhasil menambahkan {$inserted} aturan!");
    }
}