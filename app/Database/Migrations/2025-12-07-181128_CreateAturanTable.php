<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAturanTable extends Migration
{
    public function up()
    {
        // Tabel relasi gejala-penyakit dengan CF (Certainty Factor)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_penyakit' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'id_gejala' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'cf_pakar' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,2',
                'comment'    => 'Certainty Factor dari pakar (0.0 - 1.0)',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('id_penyakit', 'penyakit', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('id_gejala', 'gejala', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('aturan');

        // Insert data aturan contoh (knowledge base)
        $data = [
            // Flu (P001)
            ['id_penyakit' => 1, 'id_gejala' => 1, 'cf_pakar' => 0.8, 'created_at' => date('Y-m-d H:i:s')],  // Demam
            ['id_penyakit' => 1, 'id_gejala' => 2, 'cf_pakar' => 0.6, 'created_at' => date('Y-m-d H:i:s')],  // Batuk kering
            ['id_penyakit' => 1, 'id_gejala' => 4, 'cf_pakar' => 0.7, 'created_at' => date('Y-m-d H:i:s')],  // Pilek
            ['id_penyakit' => 1, 'id_gejala' => 5, 'cf_pakar' => 0.5, 'created_at' => date('Y-m-d H:i:s')],  // Sakit kepala
            ['id_penyakit' => 1, 'id_gejala' => 6, 'cf_pakar' => 0.4, 'created_at' => date('Y-m-d H:i:s')],  // Nyeri tenggorokan
            
            // Batuk (P002)
            ['id_penyakit' => 2, 'id_gejala' => 2, 'cf_pakar' => 0.9, 'created_at' => date('Y-m-d H:i:s')],  // Batuk kering
            ['id_penyakit' => 2, 'id_gejala' => 3, 'cf_pakar' => 0.9, 'created_at' => date('Y-m-d H:i:s')],  // Batuk berdahak
            ['id_penyakit' => 2, 'id_gejala' => 6, 'cf_pakar' => 0.5, 'created_at' => date('Y-m-d H:i:s')],  // Nyeri tenggorokan
            
            // Sakit Kepala (P003)
            ['id_penyakit' => 3, 'id_gejala' => 5, 'cf_pakar' => 1.0, 'created_at' => date('Y-m-d H:i:s')],  // Sakit kepala
            ['id_penyakit' => 3, 'id_gejala' => 10, 'cf_pakar' => 0.6, 'created_at' => date('Y-m-d H:i:s')], // Pusing
            
            // Gangguan Pencernaan (P004)
            ['id_penyakit' => 4, 'id_gejala' => 7, 'cf_pakar' => 0.8, 'created_at' => date('Y-m-d H:i:s')],  // Mual
            ['id_penyakit' => 4, 'id_gejala' => 8, 'cf_pakar' => 0.9, 'created_at' => date('Y-m-d H:i:s')],  // Diare
            ['id_penyakit' => 4, 'id_gejala' => 9, 'cf_pakar' => 0.7, 'created_at' => date('Y-m-d H:i:s')],  // Nyeri perut
        ];

        $this->db->table('aturan')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('aturan');
    }
}