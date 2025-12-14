<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PenyakitModel;
use App\Models\ObatModel;

class Penyakit extends BaseController
{
    protected $penyakitModel;
    protected $obatModel;
    protected $session;

    public function __construct()
    {
        $this->penyakitModel = new PenyakitModel();
        $this->obatModel = new ObatModel();
        $this->session = session();
        
        if ($this->session->get('role') !== 'pemilik') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }

    public function index()
    {
        $kodeOtomatis = $this->penyakitModel->generateKodePenyakit();
        $penyakit = $this->penyakitModel->getPenyakitWithAturanCount();
        $stats = $this->penyakitModel->getStatistik();

        // --- Perbaikan Dimulai Di Sini ---
        // Ambil daftar obat untuk digunakan di modal/form penambahan penyakit baru (seperti di create())
        $obatList = $this->obatModel
            ->select('id_obat, nama_obat, merk, harga_jual, stok')
            ->where('stok >', 0)
            ->orderBy('nama_obat', 'ASC')
            ->findAll();
        // --- Perbaikan Selesai Di Sini ---

        $data = [
            'title'    => 'Manajemen Penyakit',
            'penyakit' => $penyakit,
            'stats'    => $stats,
            'kodeOtomatis'  => $kodeOtomatis,
            // --- Tambahkan variabel obat_list ke view ---
            'obat_list'     => $obatList, 
        ];

        return view('admin/penyakit/index', $data);
    }

   

    public function create()
    {
        $kodeOtomatis = $this->penyakitModel->generateKodePenyakit();
        
        // ambil daftar obat untuk dipilih
        $obatList = $this->obatModel
            ->select('id_obat, nama_obat, merk, harga_jual, stok')
            ->where('stok >', 0)
            ->orderBy('nama_obat', 'ASC')
            ->findAll();

        $data = [
            'title'         => 'Tambah Penyakit Baru',
            'kode_otomatis' => $kodeOtomatis,
            'obat_list'     => $obatList
        ];

        return view('admin/penyakit/create', $data);
    }

    public function store()
    {
        $rules = [
            'kode_penyakit' => 'required|min_length[3]|max_length[10]|is_unique[penyakit.kode_penyakit]',
            'nama_penyakit' => 'required|min_length[3]|max_length[255]',
            'deskripsi'     => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $penyakitData = [
                'kode_penyakit' => strtoupper($this->request->getPost('kode_penyakit')),
                'nama_penyakit' => $this->request->getPost('nama_penyakit'),
                'deskripsi'     => $this->request->getPost('deskripsi'),
                'created_at'    => date('Y-m-d H:i:s')
            ];

            $this->penyakitModel->insert($penyakitData);
            $penyakitId = $this->penyakitModel->getInsertID();

            // simpan 
            $obatIds = $this->request->getPost('obat_ids'); // Array
            $priorities = $this->request->getPost('priorities'); // Array
            $dosages = $this->request->getPost('dosages'); // Array

            if (!empty($obatIds)) {
                foreach ($obatIds as $index => $obatId) {
                    $rekomendasiData = [
                        'id_penyakit' => $penyakitId,
                        'id_obat'     => $obatId,
                        'prioritas'   => $priorities[$index] ?? ($index + 1),
                        'dosis_saran' => $dosages[$index] ?? null,
                        'created_at'  => date('Y-m-d H:i:s')
                    ];
                    
                    $db->table('rekomendasi_obat')->insert($rekomendasiData);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Gagal menyimpan penyakit!');
            }

            return redirect()->to('/admin/penyakit')->with('success', 'Penyakit dan rekomendasi obat berhasil ditambahkan!');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $penyakit = $this->penyakitModel->getPenyakitWithAturan($id);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        // rekomendasi obat yang sudah ada
        $db = \Config\Database::connect();
        $rekomendasiObat = $db->table('rekomendasi_obat')
            ->select('rekomendasi_obat.*, obat.nama_obat, obat.merk')
            ->join('obat', 'obat.id_obat = rekomendasi_obat.id_obat')
            ->where('id_penyakit', $id)
            ->orderBy('prioritas', 'ASC')
            ->get()
            ->getResultArray();

        // obat untuk dropdown
        $obatList = $this->obatModel
            ->select('id_obat, nama_obat, merk, harga_jual, stok')
            ->where('stok >', 0)
            ->orderBy('nama_obat', 'ASC')
            ->findAll();

        $data = [
            'title'            => 'Edit Penyakit',
            'penyakit'         => $penyakit,
            'rekomendasi_obat' => $rekomendasiObat, // 🆕
            'obat_list'        => $obatList // 🆕
        ];

        return view('admin/penyakit/edit', $data);
    }

    public function update($id)
    {
        $penyakit = $this->penyakitModel->find($id);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        $rules = [
            'kode_penyakit' => "required|min_length[3]|max_length[10]|is_unique[penyakit.kode_penyakit,id,{$id}]",
            'nama_penyakit' => 'required|min_length[3]|max_length[255]',
            'deskripsi'     => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // update penyakit
            $penyakitData = [
                'kode_penyakit' => strtoupper($this->request->getPost('kode_penyakit')),
                'nama_penyakit' => $this->request->getPost('nama_penyakit'),
                'deskripsi'     => $this->request->getPost('deskripsi'),
                'updated_at'    => date('Y-m-d H:i:s')
            ];

            $this->penyakitModel->update($id, $penyakitData);

            // hapus rekomendasi lama
            $db->table('rekomendasi_obat')->where('id_penyakit', $id)->delete();

            // simpan rekomendasi baru
            $obatIds = $this->request->getPost('obat_ids');
            $priorities = $this->request->getPost('priorities');
            $dosages = $this->request->getPost('dosages');

            if (!empty($obatIds)) {
                foreach ($obatIds as $index => $obatId) {
                    $rekomendasiData = [
                        'id_penyakit' => $id,
                        'id_obat'     => $obatId,
                        'prioritas'   => $priorities[$index] ?? ($index + 1),
                        'dosis_saran' => $dosages[$index] ?? null,
                        'created_at'  => date('Y-m-d H:i:s')
                    ];
                    
                    $db->table('rekomendasi_obat')->insert($rekomendasiData);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', 'Gagal memperbarui penyakit!');
            }

            return redirect()->to('/admin/penyakit')->with('success', 'Penyakit berhasil diperbarui!');

        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        $penyakit = $this->penyakitModel->find($id);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        $hasAturan = $this->penyakitModel->hasAturan($id);

        if ($hasAturan) {
            if ($this->penyakitModel->deletePenyakitWithAturan($id)) {
                return redirect()->to('/admin/penyakit')->with('success', 'Penyakit, aturan, dan rekomendasi obat berhasil dihapus!');
            } else {
                return redirect()->to('/admin/penyakit')->with('error', 'Gagal menghapus penyakit!');
            }
        } else {
            // 🆕 Hapus rekomendasi obat juga
            $db = \Config\Database::connect();
            $db->table('rekomendasi_obat')->where('id_penyakit', $id)->delete();
            
            if ($this->penyakitModel->delete($id)) {
                return redirect()->to('/admin/penyakit')->with('success', 'Penyakit berhasil dihapus!');
            } else {
                return redirect()->to('/admin/penyakit')->with('error', 'Gagal menghapus penyakit!');
            }
        }
    }

    public function detail($id)
    {
        $penyakit = $this->penyakitModel->getPenyakitWithAturan($id);
        
        if (!$penyakit) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Penyakit tidak ditemukan');
        }

        // 🆕 Ambil rekomendasi obat
        $db = \Config\Database::connect();
        $rekomendasiObat = $db->table('rekomendasi_obat')
            ->select('rekomendasi_obat.*, obat.nama_obat, obat.merk, obat.harga_jual, obat.stok')
            ->join('obat', 'obat.id_obat = rekomendasi_obat.id_obat')
            ->where('id_penyakit', $id)
            ->orderBy('prioritas', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title'            => 'Detail Penyakit - ' . $penyakit['nama_penyakit'],
            'penyakit'         => $penyakit,
            'rekomendasi_obat' => $rekomendasiObat // 🆕
        ];

        return view('admin/penyakit/detail', $data);
    }
}