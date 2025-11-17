<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = ['id_transaksi', 'id_obat', 'jumlah', 'subtotal'];

    public function getDetailWithObat($id_transaksi)
    {
        return $this->select('transaksi_detail.*, obat.nama_obat, obat.harga')
            ->join('obat', 'obat.id_obat = transaksi_detail.id_obat')
            ->where('transaksi_detail.id_transaksi', $id_transaksi)
            ->findAll();
    }
}
