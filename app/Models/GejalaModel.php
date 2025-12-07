<?php

namespace App\Models;

use CodeIgniter\Model;

class GejalaModel extends Model
{
    protected $table            = 'gejala';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['kode_gejala', 'nama_gejala'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Get all gejala untuk form konsultasi
    public function getAllGejala()
    {
        return $this->orderBy('kode_gejala', 'ASC')->findAll();
    }

    // Get gejala by IDs
    public function getGejalaByIds($ids)
    {
        if (empty($ids)) {
            return [];
        }
        return $this->whereIn('id', $ids)->findAll();
    }
}