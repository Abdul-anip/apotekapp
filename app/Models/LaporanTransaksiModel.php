<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanTransaksiModel extends Model
{
    protected $table            = 'laporan_transaksi';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'kode_transaksi',
        'total_harga',
        'bayar',
        'kembalian',
        'items',
        'tanggal_transaksi'
    ];

    public function getLaporan()
    {
        return $this->orderBy('id', 'DESC')->findAll();
    }
}
