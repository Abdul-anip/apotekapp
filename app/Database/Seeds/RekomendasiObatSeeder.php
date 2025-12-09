<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RekomendasiObatSeeder extends Seeder
{
    public function run()
    {
        // Data rekomendasi obat untuk setiap penyakit
        // Sesuaikan id_obat dengan obat yang ada di database Anda
        
        $data = [
            // Flu (P001) - id_penyakit = 1
            [
                'id_penyakit' => 1,
                'id_obat' => 7, 
                'prioritas' => 1,
                'dosis_saran' => '3x sehari 1 tablet setelah makan',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id_penyakit' => 1,
                'id_obat' => 9,
                'prioritas' => 2,
                'dosis_saran' => '3x sehari 1 kapsul',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            
            // // Batuk (P002) - id_penyakit = 2
            // [
            //     'id_penyakit' => 2,
            //     'id_obat' => 3,
            //     'prioritas' => 1,
            //     'dosis_saran' => '3x sehari 1 sendok makan (15ml)',
            //     'created_at' => date('Y-m-d H:i:s'),
            // ],
            // [
            //     'id_penyakit' => 2,
            //     'id_obat' => 4,
            //     'prioritas' => 2,
            //     'dosis_saran' => '3-4x sehari sesuai kebutuhan',
            //     'created_at' => date('Y-m-d H:i:s'),
            // ],
            
            // // Sakit Kepala (P003) - id_penyakit = 3
            // [
            //     'id_penyakit' => 3,
            //     'id_obat' => 5,
            //     'prioritas' => 1,
            //     'dosis_saran' => '3-4x sehari 1 tablet (maksimal 4 tablet/hari)',
            //     'created_at' => date('Y-m-d H:i:s'),
            // ],
            // [
            //     'id_penyakit' => 3,
            //     'id_obat' => 6,
            //     'prioritas' => 2,
            //     'dosis_saran' => '2-3x sehari 1 tablet',
            //     'created_at' => date('Y-m-d H:i:s'),
            // ],
            
            // // Gangguan Pencernaan (P004) - id_penyakit = 4
            // [
            //     'id_penyakit' => 4,
            //     'id_obat' => 7,
            //     'prioritas' => 1,
            //     'dosis_saran' => '3x sehari 1 tablet sebelum makan',
            //     'created_at' => date('Y-m-d H:i:s'),
            // ],
            // [
            //     'id_penyakit' => 4,
            //     'id_obat' => 8,
            //     'prioritas' => 2,
            //     'dosis_saran' => 'Setiap 4-6 jam sesuai kebutuhan',
            //     'created_at' => date('Y-m-d H:i:s'),
            // ],
        ];

        // Insert data
        $this->db->table('rekomendasi_obat')->insertBatch($data);
        
        echo "✅ Seeder Rekomendasi Obat berhasil dijalankan!\n";
        echo "Total data: " . count($data) . " rekomendasi\n";
    }
}   