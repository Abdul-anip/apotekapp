<?php
// ============================================
// FILE 1: app/Controllers/Admin/DashboardSistemPakar.php
// ============================================

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class DashboardSistemPakar extends BaseController
{
    protected $session;

    public function __construct()
    {
        $this->session = session();
        
        if ($this->session->get('role') !== 'pemilik') {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Halaman tidak ditemukan');
        }
    }

    public function index()
    {
        $db = \Config\Database::connect();

        // ========== STATISTIK UTAMA ==========
        $totalPenyakit = $db->table('penyakit')->countAll();
        $totalGejala = $db->table('gejala')->countAll();
        $totalAturan = $db->table('aturan')->countAll();

        // Penyakit dengan aturan
        $penyakitDenganAturan = $db->table('penyakit')
            ->select('COUNT(DISTINCT penyakit.id) as total')
            ->join('aturan', 'aturan.id_penyakit = penyakit.id')
            ->get()->getRow()->total ?? 0;

        // Gejala terpakai
        $gejalaTerpakai = $db->table('gejala')
            ->select('COUNT(DISTINCT gejala.id) as total')
            ->join('aturan', 'aturan.id_gejala = gejala.id')
            ->get()->getRow()->total ?? 0;

        // coverage
        $coverage = $totalPenyakit > 0 ? round(($penyakitDenganAturan / $totalPenyakit) * 100, 1) : 0;

        // rata-rata CF
        $avgCF = $db->table('aturan')->selectAvg('cf_pakar')->get()->getRow()->cf_pakar ?? 0;

        // ========== TOP PENYAKIT TERDIAGNOSA ==========
        $riwayatDiagnosa = $db->table('riwayat_konsultasi')
            ->select('hasil_diagnosa')
            ->get()
            ->getResultArray();

        // Parse JSON dan hitung frekuensi penyakit
        $penyakitFrequency = [];
        foreach ($riwayatDiagnosa as $row) {
            $diagnosa = json_decode($row['hasil_diagnosa'], true);
            if (is_array($diagnosa) && !empty($diagnosa)) {
                // Ambil penyakit dengan CF tertinggi (index 0)
                $topDiagnosa = $diagnosa[0];
                $namaPenyakit = $topDiagnosa['nama_penyakit'] ?? '';
                
                if (!empty($namaPenyakit)) {
                    if (isset($penyakitFrequency[$namaPenyakit])) {
                        $penyakitFrequency[$namaPenyakit]++;
                    } else {
                        $penyakitFrequency[$namaPenyakit] = 1;
                    }
                }
            }
        }

        // Sort by frequency descending
        arsort($penyakitFrequency);
        
        // Convert to array format
        $topPenyakit = [];
        $count = 0;
        foreach ($penyakitFrequency as $nama => $jumlah) {
            if ($count >= 10) break;
            $topPenyakit[] = [
                'nama_penyakit' => $nama,
                'jumlah'        => $jumlah
            ];
            $count++;
        }

        // ========== GEJALA PALING SERING DIPILIH ==========
        // Alternatif tanpa JSON_TABLE (kompatibel dengan MariaDB < 10.6)
        $riwayatKonsultasi = $db->table('riwayat_konsultasi')
            ->select('gejala_input')
            ->get()
            ->getResultArray();

        // Parse JSON dan hitung frekuensi secara manual
        $gejalaFrequency = [];
        foreach ($riwayatKonsultasi as $row) {
            $gejalaIds = json_decode($row['gejala_input'], true);
            if (is_array($gejalaIds)) {
                foreach ($gejalaIds as $id) {
                    if (isset($gejalaFrequency[$id])) {
                        $gejalaFrequency[$id]++;
                    } else {
                        $gejalaFrequency[$id] = 1;
                    }
                }
            }
        }

        // Sort by frequency descending
        arsort($gejalaFrequency);
        
        // Get top 10 gejala details
        $topGejala = [];
        $count = 0;
        foreach ($gejalaFrequency as $id => $freq) {
            if ($count >= 10) break;
            
            $gejala = $db->table('gejala')
                ->where('id', $id)
                ->get()
                ->getRowArray();
            
            if ($gejala) {
                $topGejala[] = [
                    'nama_gejala' => $gejala['nama_gejala'],
                    'kode_gejala' => $gejala['kode_gejala'],
                    'frekuensi'   => $freq
                ];
                $count++;
            }
        }

        // ========== PENYAKIT TANPA ATURAN ==========
        $penyakitTanpaAturan = $db->table('penyakit')
            ->select('penyakit.*')
            ->join('aturan', 'aturan.id_penyakit = penyakit.id', 'left')
            ->where('aturan.id IS NULL')
            ->limit(5)
            ->get()
            ->getResultArray();

        // ========== GEJALA TIDAK TERPAKAI ==========
        $gejalaTidakTerpakai = $db->table('gejala')
            ->select('gejala.*')
            ->join('aturan', 'aturan.id_gejala = gejala.id', 'left')
            ->where('aturan.id IS NULL')
            ->limit(5)
            ->get()
            ->getResultArray();

        // ========== ATURAN DENGAN CF RENDAH ==========
        $aturanCFRendah = $db->table('aturan')
            ->select('aturan.*, penyakit.nama_penyakit, gejala.nama_gejala')
            ->join('penyakit', 'penyakit.id = aturan.id_penyakit')
            ->join('gejala', 'gejala.id = aturan.id_gejala')
            ->where('aturan.cf_pakar <', 0.3)
            ->orderBy('aturan.cf_pakar', 'ASC')
            ->limit(5)
            ->get()
            ->getResultArray();

        // ========== AKTIVITAS KONSULTASI (30 HARI) ==========
        $konsultasiHarian = $db->query("
            SELECT DATE(tanggal_konsultasi) as tanggal, COUNT(*) as jumlah
            FROM riwayat_konsultasi
            WHERE tanggal_konsultasi >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
            GROUP BY DATE(tanggal_konsultasi)
            ORDER BY tanggal DESC
            LIMIT 30
        ")->getResultArray();

        // Total konsultasi
        $totalKonsultasi = $db->table('riwayat_konsultasi')->countAll();

        $data = [
            'title' => 'Dashboard Sistem Pakar',
            'stats' => [
                'total_penyakit' => $totalPenyakit,
                'total_gejala' => $totalGejala,
                'total_aturan' => $totalAturan,
                'penyakit_dengan_aturan' => $penyakitDenganAturan,
                'gejala_terpakai' => $gejalaTerpakai,
                'coverage' => $coverage,
                'avg_cf' => round($avgCF, 2),
                'total_konsultasi' => $totalKonsultasi
            ],
            'top_penyakit' => $topPenyakit,
            'top_gejala' => $topGejala,
            'penyakit_tanpa_aturan' => $penyakitTanpaAturan,
            'gejala_tidak_terpakai' => $gejalaTidakTerpakai,
            'aturan_cf_rendah' => $aturanCFRendah,
            'konsultasi_harian' => array_reverse($konsultasiHarian)
        ];

        return view('admin/sistem_pakar/dashboard', $data);
    }
}

