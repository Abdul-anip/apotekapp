<?php

namespace App\Models;

use CodeIgniter\Model;

class SistemPakarModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    /**
     * FORWARD CHAINING: Proses diagnosa berdasarkan gejala
     * 
     * @param array $gejala_ids Array of gejala IDs yang dipilih
     * @param array $cf_user Array of CF user untuk setiap gejala (optional)
     * @return array Hasil diagnosa dengan CF
     */
    public function diagnosa($gejala_ids, $cf_user = [])
    {
        if (empty($gejala_ids)) {
            return [];
        }

        // Default CF user = 1.0 jika tidak diisi
        if (empty($cf_user)) {
            $cf_user = array_fill(0, count($gejala_ids), 1.0);
        }

        $hasil_diagnosa = [];

        // Dapatkan semua penyakit yang memiliki gejala dari input
        $query = $this->db->table('aturan')
            ->select('penyakit.id, penyakit.kode_penyakit, penyakit.nama_penyakit, penyakit.deskripsi')
            ->join('penyakit', 'penyakit.id = aturan.id_penyakit')
            ->whereIn('aturan.id_gejala', $gejala_ids)
            ->groupBy('penyakit.id')
            ->get();

        $penyakit_list = $query->getResultArray();

        foreach ($penyakit_list as $penyakit) {
            // Dapatkan aturan (gejala) untuk penyakit ini
            $aturan_query = $this->db->table('aturan')
                ->select('id_gejala, cf_pakar')
                ->where('id_penyakit', $penyakit['id'])
                ->whereIn('id_gejala', $gejala_ids)
                ->get();

            $aturan = $aturan_query->getResultArray();

            if (empty($aturan)) {
                continue;
            }

            // Hitung CF kombinasi untuk penyakit ini
            $cf_hasil = $this->hitungCF($aturan, $gejala_ids, $cf_user);

            $hasil_diagnosa[] = [
                'id_penyakit'    => $penyakit['id'],
                'kode_penyakit'  => $penyakit['kode_penyakit'],
                'nama_penyakit'  => $penyakit['nama_penyakit'],
                'deskripsi'      => $penyakit['deskripsi'],
                'cf_hasil'       => round($cf_hasil, 4),
                'persentase'     => round($cf_hasil * 100, 2),
            ];
        }

        // Urutkan berdasarkan CF tertinggi
        usort($hasil_diagnosa, function($a, $b) {
            return $b['cf_hasil'] <=> $a['cf_hasil'];
        });

        return $hasil_diagnosa;
    }

    /**
     * Hitung Certainty Factor kombinasi
     * Rumus: CF(H,E) = CF(E) * CF(H,E)
     * Untuk kombinasi: CF_combine = CF1 + CF2 * (1 - CF1)
     * 
     * @param array $aturan Array of rules dengan cf_pakar
     * @param array $gejala_ids Array of gejala IDs yang dipilih
     * @param array $cf_user Array of CF user
     * @return float CF hasil
     */
    private function hitungCF($aturan, $gejala_ids, $cf_user)
    {
        $cf_list = [];

        foreach ($aturan as $rule) {
            $index = array_search($rule['id_gejala'], $gejala_ids);
            if ($index !== false) {
                // CF(H,E) = CF(pakar) * CF(user)
                $cf_he = $rule['cf_pakar'] * $cf_user[$index];
                $cf_list[] = $cf_he;
            }
        }

        if (empty($cf_list)) {
            return 0;
        }

        // Kombinasi CF menggunakan rumus kombinasi paralel
        $cf_kombinasi = $cf_list[0];

        for ($i = 1; $i < count($cf_list); $i++) {
            // CF_combine = CF_old + CF_new * (1 - CF_old)
            $cf_kombinasi = $cf_kombinasi + $cf_list[$i] * (1 - $cf_kombinasi);
        }

        return $cf_kombinasi;
    }

    /**
     * Dapatkan rekomendasi obat berdasarkan penyakit
     * 
     * @param int $id_penyakit ID penyakit
     * @return array Daftar obat yang direkomendasikan
     */
    public function getRekomendasiObat($id_penyakit)
    {
        $query = $this->db->table('rekomendasi_obat')
            ->select('obat.*, rekomendasi_obat.prioritas, rekomendasi_obat.dosis_saran, kategori.nama_kategori')
            ->join('obat', 'obat.id_obat = rekomendasi_obat.id_obat')
            ->join('kategori', 'kategori.id = obat.category_id', 'left')
            ->where('rekomendasi_obat.id_penyakit', $id_penyakit)
            ->where('obat.stok >', 0)
            ->orderBy('rekomendasi_obat.prioritas', 'ASC')
            ->get();

        return $query->getResultArray();
    }

    /**
     * Simpan riwayat konsultasi
     * 
     * @param array $data Data konsultasi
     * @return int Insert ID
     */
    public function simpanRiwayat($data)
    {
        $kode_konsultasi = 'KONSUL-' . date('YmdHis') . '-' . rand(100, 999);

        $insert_data = [
            'kode_konsultasi'        => $kode_konsultasi,
            'id_user'                => $data['id_user'],
            'gejala_input'           => json_encode($data['gejala_input']),
            'hasil_diagnosa'         => json_encode($data['hasil_diagnosa']),
            'obat_direkomendasikan'  => json_encode($data['obat_direkomendasikan'] ?? []),
            'tanggal_konsultasi'     => date('Y-m-d H:i:s'),
            'created_at'             => date('Y-m-d H:i:s'),
        ];

        $this->db->table('riwayat_konsultasi')->insert($insert_data);
        return $this->db->insertID();
    }
}