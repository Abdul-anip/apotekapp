<?php
namespace App\Models;
use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    
    protected $allowedFields = [
        'tanggal_transaksi',
        'total',
        'uang_dibayar',
        'uang_kembalian'
    ];
    
    protected $useTimestamps = false;
    
    // Validasi
    protected $validationRules = [
        'total'    => 'required|decimal',
        'uang_dibayar'   => 'required|decimal',
        'uang_kembalian' => 'permit_empty|decimal'
    ];
    
    protected $validationMessages = [
        'total' => [
            'required' => 'Total harga harus diisi',
            'decimal'  => 'Total harga harus berupa angka'
        ],
        'uang_dibayar' => [
            'required' => 'Uang dibayar harus diisi',
            'decimal'  => 'Uang dibayar harus berupa angka'
        ]
    ];
}