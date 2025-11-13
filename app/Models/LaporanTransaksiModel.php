<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanTransaksiModel extends Model
{
    protected $table            = 'laporan_transaksi';
    protected $primaryKey       = 'id_laporan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'id_transaksi',
        'total_harga',
        'uang_dibayar',
        'uang_kembalian',
        'tanggal_transaksi',
        'created_at',
        'updated_at',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
