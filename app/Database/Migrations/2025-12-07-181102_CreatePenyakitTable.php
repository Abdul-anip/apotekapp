<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenyakitTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'kode_penyakit' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'unique'     => true,
            ],
            'nama_penyakit' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
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
        $this->forge->createTable('penyakit');

        // Insert data penyakit contoh
        $data = [
            [
                'kode_penyakit' => 'P001',
                'nama_penyakit' => 'Flu/Influenza',
                'deskripsi' => 'Infeksi virus yang menyerang sistem pernapasan',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_penyakit' => 'P002',
                'nama_penyakit' => 'Batuk',
                'deskripsi' => 'Refleks tubuh untuk membersihkan saluran pernapasan',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_penyakit' => 'P003',
                'nama_penyakit' => 'Sakit Kepala/Migrain',
                'deskripsi' => 'Nyeri kepala yang bisa ringan hingga berat',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'kode_penyakit' => 'P004',
                'nama_penyakit' => 'Gangguan Pencernaan',
                'deskripsi' => 'Masalah pada sistem pencernaan seperti diare, mual',
                'created_at' => date('Y-m-d H:i:s')
            ],
        ];

        $this->db->table('penyakit')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('penyakit');
    }
}