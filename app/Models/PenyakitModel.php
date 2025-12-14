<?php

namespace App\Models;

use CodeIgniter\Model;

class PenyakitModel extends Model
{
    protected $table            = 'penyakit';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['kode_penyakit', 'nama_penyakit', 'deskripsi'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'kode_penyakit' => 'required|min_length[3]|max_length[10]|is_unique[penyakit.kode_penyakit,id,{id}]',
        'nama_penyakit' => 'required|min_length[3]|max_length[255]',
        'deskripsi'     => 'permit_empty|max_length[1000]'
    ];

    protected $validationMessages = [
        'kode_penyakit' => [
            'required'   => 'Kode penyakit harus diisi',
            'min_length' => 'Kode penyakit minimal 3 karakter',
            'is_unique'  => 'Kode penyakit sudah digunakan'
        ],
        'nama_penyakit' => [
            'required'   => 'Nama penyakit harus diisi',
            'min_length' => 'Nama penyakit minimal 3 karakter'
        ]
    ];

    public function generateKodePenyakit()
    {
        $lastPenyakit = $this->orderBy('id', 'DESC')->first();
        
        if (!$lastPenyakit) {
            return 'P001';
        }
        
        // ambil nomor dari kode terakhir
        $lastKode = $lastPenyakit['kode_penyakit'];
        $number = (int)substr($lastKode, 1); // Ambil angka setelah 'P'
        $newNumber = $number + 1;
        
        return 'P' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function getPenyakitWithAturanCount()
    {
        return $this->select('penyakit.*, COUNT(aturan.id) as jumlah_aturan')
            ->join('aturan', 'aturan.id_penyakit = penyakit.id', 'left')
            ->groupBy('penyakit.id')
            ->orderBy('penyakit.nama_penyakit', 'ASC')
            ->findAll();
    }

    /**
     * Get penyakit by ID dengan detail aturan
     */
    public function getPenyakitWithAturan($id)
    {
        $penyakit = $this->find($id);
        
        if (!$penyakit) {
            return null;
        }
        
        // Ambil aturan untuk penyakit ini
        $db = \Config\Database::connect();
        $aturan = $db->table('aturan')
            ->select('aturan.*, gejala.kode_gejala, gejala.nama_gejala')
            ->join('gejala', 'gejala.id = aturan.id_gejala')
            ->where('aturan.id_penyakit', $id)
            ->orderBy('aturan.cf_pakar', 'DESC')
            ->get()
            ->getResultArray();
        
        $penyakit['aturan'] = $aturan;
        
        return $penyakit;
    }

    public function hasAturan($id)
    {
        $db = \Config\Database::connect();
        $count = $db->table('aturan')
            ->where('id_penyakit', $id)
            ->countAllResults();
        
        return $count > 0;
    }

    public function deletePenyakitWithAturan($id)
    {
        $db = \Config\Database::connect();
        $db->transStart();
        
        // Hapus aturan terkait
        $db->table('aturan')->where('id_penyakit', $id)->delete();
        
        // Hapus rekomendasi obat terkait
        $db->table('rekomendasi_obat')->where('id_penyakit', $id)->delete();
        
        // Hapus penyakit
        $this->delete($id);
        
        $db->transComplete();
        
        return $db->transStatus();
    }

    /**
     * Get statistik penyakit
     */
    public function getStatistik()
    {
        $db = \Config\Database::connect();
        
        $totalPenyakit = $this->countAll();
        
        // Penyakit dengan aturan
        $penyakitDenganAturan = $db->table('penyakit')
            ->select('COUNT(DISTINCT penyakit.id) as total')
            ->join('aturan', 'aturan.id_penyakit = penyakit.id')
            ->get()
            ->getRow()
            ->total ?? 0;
        
        // Penyakit tanpa aturan
        $penyakitTanpaAturan = $totalPenyakit - $penyakitDenganAturan;
        
        // Rata-rata aturan per penyakit
        $avgAturanPerPenyakit = $penyakitDenganAturan > 0 
            ? round($db->table('aturan')->countAll() / $penyakitDenganAturan, 1) 
            : 0;
        
        return [
            'total'                  => $totalPenyakit,
            'dengan_aturan'          => $penyakitDenganAturan,
            'tanpa_aturan'           => $penyakitTanpaAturan,
            'avg_aturan_per_penyakit' => $avgAturanPerPenyakit
        ];
    }
}