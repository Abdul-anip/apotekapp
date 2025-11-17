<?php

namespace App\Controllers;

use App\Models\LaporanTransaksiModel;

class Laporan extends BaseController
{
    public function index()
    {
    $laporanModel = new \App\Models\LaporanTransaksiModel();
    $laporan = $laporanModel->findAll();

    foreach ($laporan as &$row) {
        $row['items'] = json_decode($row['items'], true) ?? []; // jika null → ubah jadi array kosong
    }

    return view('laporan/index', ['laporan' => $laporan]);
    }
}
