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

        // 🟢 Total Obat
        $totalObat = $obatModel->countAll();

        // 🟢 Transaksi Hari Ini
        $today = date('Y-m-d');
        $transaksiHariIni = $laporanModel
            ->where('DATE(tanggal)', $today)
            ->countAllResults();

        // 🟢 Total Penjualan Hari Ini
        $penjualanHariIni = $laporanModel
            ->selectSum('total_harga')
            ->where('DATE(tanggal)', $today)
            ->first();
        $totalPenjualanHariIni = $penjualanHariIni['total_harga'] ?? 0;

        // 🟢 Keuntungan Hari Ini
        $keuntunganHariIni = $laporanModel
            ->selectSum('keuntungan')
            ->where('DATE(tanggal)', $today)
            ->first();
        $totalKeuntunganHariIni = $keuntunganHariIni['keuntungan'] ?? 0;

        // 🟢 Stok Menipis (stok < 10)
        $stokMenipis = $obatModel
            ->where('stok <', 10)
            ->countAllResults();

        // 🟢 Obat dengan Stok Menipis (untuk detail)
        $obatStokMenipis = $obatModel
            ->select('obat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->where('stok <', 10)
            ->orderBy('stok', 'ASC')
            ->limit(5)
            ->findAll();

        // 🔴 FITUR BARU: Obat Akan Kadaluarsa (dalam 30 hari)
        $tigaPuluhHariKedepan = date('Y-m-d', strtotime('+30 days'));
        $obatAkanKadaluarsa = $obatModel
            ->where('tanggal_kadaluarsa <=', $tigaPuluhHariKedepan)
            ->where('tanggal_kadaluarsa >=', $today)
            ->countAllResults();

        // 🔴 Detail Obat Akan Kadaluarsa
        $obatKadaluarsaDetail = $obatModel
            ->select('obat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->where('tanggal_kadaluarsa <=', $tigaPuluhHariKedepan)
            ->where('tanggal_kadaluarsa >=', $today)
            ->orderBy('tanggal_kadaluarsa', 'ASC')
            ->limit(5)
            ->findAll();

        // 🔴 Obat Sudah Kadaluarsa
        $obatSudahKadaluarsa = $obatModel
            ->where('tanggal_kadaluarsa <', $today)
            ->countAllResults();

        // 🔴 Detail Obat Sudah Kadaluarsa
        $obatSudahKadaluarsaDetail = $obatModel
            ->select('obat.*, kategori.nama_kategori')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->where('tanggal_kadaluarsa <', $today)
            ->orderBy('tanggal_kadaluarsa', 'DESC')
            ->limit(5)
            ->findAll();

        // 🟢 Transaksi Terbaru Hari Ini
        $transaksiTerbaru = $laporanModel
            ->where('DATE(tanggal)', $today)
            ->orderBy('id', 'DESC')
            ->limit(5)
            ->findAll();

        // Parse items JSON
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
            // 🔴 Data Baru
            'obatAkanKadaluarsa' => $obatAkanKadaluarsa,
            'obatKadaluarsaDetail' => $obatKadaluarsaDetail,
            'obatSudahKadaluarsa' => $obatSudahKadaluarsa,
            'obatSudahKadaluarsaDetail' => $obatSudahKadaluarsaDetail,
            'transaksiTerbaru' => $transaksiTerbaru,
        ];

        return view('dashboard', $data);
    }
}