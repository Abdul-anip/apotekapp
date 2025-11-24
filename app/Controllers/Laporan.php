<?php

namespace App\Controllers;

use App\Models\LaporanTransaksiModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseController
{
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanTransaksiModel();
    }

    public function index()
    {
        $laporan = $this->laporanModel->orderBy('id', 'DESC')->findAll();

        foreach ($laporan as &$row) {
            $row['items'] = json_decode($row['items'], true) ?? [];
        }

        $data = [
            'title' => 'Laporan Transaksi',
            'laporan' => $laporan
        ];

        return view('laporan/index', $data);
    }

    // 🟢 Cetak Semua Laporan
    public function cetakSemua()
    {
        $laporan = $this->laporanModel->orderBy('tanggal', 'DESC')->findAll();

        foreach ($laporan as &$row) {
            $row['items'] = json_decode($row['items'], true) ?? [];
        }

        $data = [
            'title' => 'Laporan Transaksi Lengkap',
            'laporan' => $laporan,
            'periode' => 'Semua Periode',
            'total_transaksi' => count($laporan),
            'total_penjualan' => array_sum(array_column($laporan, 'total_harga')),
            'total_keuntungan' => array_sum(array_column($laporan, 'keuntungan')),
        ];

        return $this->generatePDF($data, 'Laporan_Lengkap_' . date('Y-m-d'));
    }

    // 🟢 Cetak Per Periode
    public function cetakPeriode()
    {
        $tanggal_mulai = $this->request->getGet('tanggal_mulai');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');

        if (empty($tanggal_mulai) || empty($tanggal_akhir)) {
            return redirect()->back()->with('error', 'Harap pilih periode tanggal!');
        }

        $laporan = $this->laporanModel
            ->where('DATE(tanggal) >=', $tanggal_mulai)
            ->where('DATE(tanggal) <=', $tanggal_akhir)
            ->orderBy('tanggal', 'DESC')
            ->findAll();

        foreach ($laporan as &$row) {
            $row['items'] = json_decode($row['items'], true) ?? [];
        }

        $data = [
            'title' => 'Laporan Transaksi Per Periode',
            'laporan' => $laporan,
            'periode' => date('d M Y', strtotime($tanggal_mulai)) . ' - ' . date('d M Y', strtotime($tanggal_akhir)),
            'total_transaksi' => count($laporan),
            'total_penjualan' => array_sum(array_column($laporan, 'total_harga')),
            'total_keuntungan' => array_sum(array_column($laporan, 'keuntungan')),
        ];

        return $this->generatePDF($data, 'Laporan_' . $tanggal_mulai . '_' . $tanggal_akhir);
    }

    // 🟢 Cetak Struk Individual
    public function cetakStruk($id)
    {
        $transaksi = $this->laporanModel->find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan!');
        }

        $transaksi['items'] = json_decode($transaksi['items'], true) ?? [];

        $data = [
            'transaksi' => $transaksi,
            'title' => 'Struk Transaksi'
        ];

        return view('laporan/struk_print', $data);
    }

    // 🟢 Generate PDF
    private function generatePDF($data, $filename)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        
        $html = view('laporan/pdf_template', $data);
        
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        
        $dompdf->stream($filename . '.pdf', ['Attachment' => false]);
    }
}