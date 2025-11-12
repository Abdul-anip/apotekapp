<?php
namespace App\Controllers;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use App\Models\ObatModel;

class Laporan extends BaseController
{
    protected $transaksi, $detail, $obat;

    public function __construct()
    {
        $this->transaksi = new TransaksiModel();
        $this->detail = new TransaksiDetailModel();
        $this->obat = new ObatModel();
    }

    // Halaman laporan
    public function index()
    {
        $data['title'] = "Laporan Penjualan";
        $data['transaksi'] = $this->transaksi->orderBy('tanggal','DESC')->findAll();
        return view('laporan/index', $data);
    }

    // Detail transaksi
    public function detail($id_transaksi)
    {
        $data['title'] = "Detail Transaksi";
        $data['transaksi'] = $this->transaksi->find($id_transaksi);
        $data['detail'] = $this->detail
                              ->join('obat','obat.id_obat=transaksi_detail.id_obat')
                              ->where('id_transaksi',$id_transaksi)
                              ->findAll();
        return view('laporan/detail', $data);
    }
}
