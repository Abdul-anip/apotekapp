<?php
namespace App\Models;
use CodeIgniter\Model;

class ObatModel extends Model
{
    protected $table = 'obat';
    protected $primaryKey = 'id_obat';
    protected $allowedFields = ['nama_obat','category_id','harga_beli','harga_jual','stok','tanggal_kadaluarsa'];
}
