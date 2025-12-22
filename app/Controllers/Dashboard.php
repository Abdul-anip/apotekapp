<?php
namespace App\Controllers;

use App\Models\ObatModel;
use App\Models\LaporanTransaksiModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $obatModel = new ObatModel();
        $laporanModel = new LaporanTransaksiModel();

        $totalObat = $obatModel->countAll();

        $today = date('Y-m-d');
        $transaksiHariIni = $laporanModel
            ->where('DATE(tanggal)', $today)
            ->countAllResults();

         $penjualanHariIni = $laporanModel
            ->selectSum('total_harga')
            ->where('DATE(tanggal)', $today)
            ->first();
        $totalPenjualanHariIni = $penjualanHariIni['total_harga'] ?? 0;

        $keuntunganHariIni = $laporanModel
            ->selectSum('keuntungan')
            ->where('DATE(tanggal)', $today)
            ->first();
        $totalKeuntunganHariIni = $keuntunganHariIni['keuntungan'] ?? 0;

        $stokMenipis = $obatModel
            ->where('stok <', 10)
            ->countAllResults();

        $obatStokMenipis = $obatModel
            ->select('obat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->where('stok <', 10)
            ->orderBy('stok', 'ASC')
            ->limit(5)
            ->findAll();

        $tigaPuluhHariKedepan = date('Y-m-d', strtotime('+30 days'));
        $obatAkanKadaluarsa = $obatModel
            ->where('tanggal_kadaluarsa <=', $tigaPuluhHariKedepan)
            ->where('tanggal_kadaluarsa >=', $today)
            ->countAllResults();

        $obatKadaluarsaDetail = $obatModel
            ->select('obat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->where('tanggal_kadaluarsa <=', $tigaPuluhHariKedepan)
            ->where('tanggal_kadaluarsa >=', $today)
            ->orderBy('tanggal_kadaluarsa', 'ASC')
            ->limit(5)
            ->findAll();

        $obatSudahKadaluarsa = $obatModel
            ->where('tanggal_kadaluarsa <', $today)
            ->countAllResults();

        $obatSudahKadaluarsaDetail = $obatModel
            ->select('obat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->where('tanggal_kadaluarsa <', $today)
            ->orderBy('tanggal_kadaluarsa', 'DESC')
            ->limit(5)
            ->findAll();

        $transaksiTerbaru = $laporanModel
            ->where('DATE(tanggal)', $today)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->findAll();

        foreach ($transaksiTerbaru as &$row) {
            $row['items'] = json_decode($row['items'], true) ?? [];
        }

        $data = [
            'title' => "Dashboard POS Apotek",
            'totalObat' => $totalObat,
            'transaksiHariIni' => $transaksiHariIni,
            'totalPenjualanHariIni' => $totalPenjualanHariIni,
            'totalKeuntunganHariIni' => $totalKeuntunganHariIni,
            'stokMenipis' => $stokMenipis,
            'obatStokMenipis' => $obatStokMenipis,
            // data Baru
            'obatAkanKadaluarsa' => $obatAkanKadaluarsa,
            'obatKadaluarsaDetail' => $obatKadaluarsaDetail,
            'obatSudahKadaluarsa' => $obatSudahKadaluarsa,
            'obatSudahKadaluarsaDetail' => $obatSudahKadaluarsaDetail,
            'transaksiTerbaru' => $transaksiTerbaru,
        ];

        return view('dashboard', $data);
    }
}