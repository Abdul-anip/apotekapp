<?php

namespace App\Controllers;

use App\Models\GejalaModel;
use App\Models\SistemPakarModel;

class Konsultasi extends BaseController
{
    protected $gejalaModel;
    protected $sistemPakarModel;
    protected $session;

    public function __construct()
    {
        $this->gejalaModel = new GejalaModel();
        $this->sistemPakarModel = new SistemPakarModel();
        $this->session = session();
    }

    /**
     * Halaman form input gejala
     */
    public function index()
    {
        $data = [
            'title' => 'Konsultasi Gejala Pelanggan',
            'gejala_list' => $this->gejalaModel->getAllGejala(),
        ];

        return view('konsultasi/index', $data);
    }

    public function proses()
    {
        // Validasi input
        $gejala_ids = $this->request->getPost('gejala');
        
        if (empty($gejala_ids)) {
            return redirect()->back()->with('error', 'Pilih minimal 1 gejala!');
        }

        // Optional: CF user (tingkat kepercayaan user terhadap gejala)
        // Untuk kesederhanaan, kita set semua CF user = 1.0
        $cf_user = array_fill(0, count($gejala_ids), 1.0);

        // Proses Forward Chaining
        $hasil_diagnosa = $this->sistemPakarModel->diagnosa($gejala_ids, $cf_user);

        if (empty($hasil_diagnosa)) {
            return redirect()->back()->with('error', 'Tidak ada penyakit yang cocok dengan gejala tersebut.');
        }

        // Dapatkan detail gejala yang dipilih
        $gejala_dipilih = $this->gejalaModel->getGejalaByIds($gejala_ids);

        $penyakit_utama = $hasil_diagnosa[0];
        $rekomendasi_obat = $this->sistemPakarModel->getRekomendasiObat($penyakit_utama['id_penyakit']);

        $this->session->set('hasil_diagnosa', [
            'gejala_dipilih'   => $gejala_dipilih,
            'hasil_diagnosa'   => $hasil_diagnosa,
            'rekomendasi_obat' => $rekomendasi_obat,
        ]);

        $this->sistemPakarModel->simpanRiwayat([
            'id_user'                => $this->session->get('user_id'),
            'gejala_input'           => $gejala_ids,
            'hasil_diagnosa'         => $hasil_diagnosa,
            'obat_direkomendasikan'  => array_column($rekomendasi_obat, 'id_obat'),
        ]);

        return redirect()->to('/konsultasi/hasil');
    }

    public function hasil()
    {
        $hasil = $this->session->get('hasil_diagnosa');

        if (empty($hasil)) {
            return redirect()->to('/konsultasi')->with('error', 'Belum ada hasil diagnosa. Silakan lakukan konsultasi terlebih dahulu.');
        }

        $data = [
            'title'            => 'Hasil Diagnosa',
            'gejala_dipilih'   => $hasil['gejala_dipilih'],
            'hasil_diagnosa'   => $hasil['hasil_diagnosa'],
            'rekomendasi_obat' => $hasil['rekomendasi_obat'],
        ];

        return view('konsultasi/hasil', $data);
    }

    public function riwayat()
    {
        $db = \Config\Database::connect();
        
        $query = $db->table('riwayat_konsultasi')
            ->select('riwayat_konsultasi.*, users.nama_lengkap')
            ->join('users', 'users.id = riwayat_konsultasi.id_user')
            ->orderBy('tanggal_konsultasi', 'DESC')
            ->limit(50)
            ->get();

        $riwayat = $query->getResultArray();

        // Decode JSON
        foreach ($riwayat as &$row) {
            $row['gejala_input'] = json_decode($row['gejala_input'], true);
            $row['hasil_diagnosa'] = json_decode($row['hasil_diagnosa'], true);
            $row['obat_direkomendasikan'] = json_decode($row['obat_direkomendasikan'], true);
        }

        $data = [
            'title' => 'Riwayat Konsultasi',
            'riwayat' => $riwayat,
        ];

        return view('konsultasi/riwayat', $data);
    }
}