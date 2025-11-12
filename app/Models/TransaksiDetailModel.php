<?php
namespace App\Models;
use CodeIgniter\Model;

class TransaksiDetailModel extends Model
{
    protected $table = 'transaksi_detail';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = ['id_transaksi','id_obat','jumlah','subtotal'];
}
