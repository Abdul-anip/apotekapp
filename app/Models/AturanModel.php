<?php

namespace App\Models;

use CodeIgniter\Model;

class AturanModel extends Model
{
    protected $table            = 'aturan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['id_penyakit', 'id_gejala', 'cf_pakar'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Validation Rules
    protected $validationRules = [
        'id_penyakit' => 'required|integer',
        'id_gejala'   => 'required|integer',
        'cf_pakar'    => 'required|decimal|greater_than[0]|less_than_equal_to[1]'
    ];

    protected $validationMessages = [
        'id_penyakit' => [
            'required' => 'Penyakit harus dipilih',
            'integer'  => 'ID penyakit tidak valid'
        ],
        'id_gejala' => [
            'required' => 'Gejala harus dipilih',
            'integer'  => 'ID gejala tidak valid'
        ],
        'cf_pakar' => [
            'required'            => 'CF Pakar harus diisi',
            'decimal'             => 'CF Pakar harus berupa angka desimal',
            'greater_than'        => 'CF Pakar harus lebih dari 0',
            'less_than_equal_to'  => 'CF Pakar maksimal 1.0'
        ]
    ];

    /**
     * Get aturan with penyakit and gejala details
     */
    public function getAturanWithDetails()
    {
        return $this->select('aturan.*, penyakit.nama_penyakit, penyakit.kode_penyakit, gejala.nama_gejala, gejala.kode_gejala')
            ->join('penyakit', 'penyakit.id = aturan.id_penyakit')
            ->join('gejala', 'gejala.id = aturan.id_gejala')
            ->orderBy('penyakit.nama_penyakit', 'ASC')
            ->findAll();
    }

    /**
     * Get aturan by penyakit ID
     */
    public function getByPenyakit($id_penyakit)
    {
        return $this->select('aturan.*, gejala.nama_gejala, gejala.kode_gejala')
            ->join('gejala', 'gejala.id = aturan.id_gejala')
            ->where('aturan.id_penyakit', $id_penyakit)
            ->orderBy('aturan.cf_pakar', 'DESC')
            ->findAll();
    }

    /**
     * Get aturan by gejala ID
     */
    public function getByGejala($id_gejala)
    {
        return $this->select('aturan.*, penyakit.nama_penyakit, penyakit.kode_penyakit')
            ->join('penyakit', 'penyakit.id = aturan.id_penyakit')
            ->where('aturan.id_gejala', $id_gejala)
            ->orderBy('aturan.cf_pakar', 'DESC')
            ->findAll();
    }

    /**
     * Check if aturan exists for penyakit-gejala combination
     */
    public function exists($id_penyakit, $id_gejala, $exclude_id = null)
    {
        $builder = $this->where('id_penyakit', $id_penyakit)
                        ->where('id_gejala', $id_gejala);
        
        if ($exclude_id) {
            $builder->where('id !=', $exclude_id);
        }
        
        return $builder->first() !== null;
    }

    /**
     * Get penyakit tanpa aturan
     */
    public function getPenyakitTanpaAturan()
    {
        $db = \Config\Database::connect();
        
        return $db->table('penyakit')
            ->select('penyakit.*')
            ->join('aturan', 'aturan.id_penyakit = penyakit.id', 'left')
            ->where('aturan.id IS NULL')
            ->get()
            ->getResultArray();
    }

    /**
     * Get statistik aturan
     */
    public function getStatistik()
    {
        $db = \Config\Database::connect();
        
        // Total aturan
        $totalAturan = $this->countAll();
        
        // Penyakit dengan aturan
        $penyakitDenganAturan = $db->table('penyakit')
            ->select('COUNT(DISTINCT penyakit.id) as total')
            ->join('aturan', 'aturan.id_penyakit = penyakit.id')
            ->get()
            ->getRow()
            ->total ?? 0;
        
        // Total penyakit
        $totalPenyakit = $db->table('penyakit')->countAll();
        
        // Total gejala
        $totalGejala = $db->table('gejala')->countAll();
        
        // Coverage (persentase penyakit yang punya aturan)
        $coverage = $totalPenyakit > 0 ? round(($penyakitDenganAturan / $totalPenyakit) * 100, 1) : 0;
        
        // Rata-rata CF
        $avgCF = $db->table('aturan')
            ->selectAvg('cf_pakar')
            ->get()
            ->getRow()
            ->cf_pakar ?? 0;
        
        return [
            'total_aturan'          => $totalAturan,
            'total_penyakit'        => $totalPenyakit,
            'penyakit_dengan_aturan' => $penyakitDenganAturan,
            'total_gejala'          => $totalGejala,
            'coverage'              => $coverage,
            'avg_cf'                => round($avgCF, 2)
        ];
    }

    /**
     * Bulk insert aturan
     */
    public function bulkInsert($data)
    {
        return $this->insertBatch($data);
    }

    /**
     * Validate CF Pakar value
     */
    public function isValidCF($cf)
    {
        return is_numeric($cf) && $cf > 0 && $cf <= 1;
    }
}