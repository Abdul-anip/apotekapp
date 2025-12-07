<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRekomendasiObatTable extends Migration
{
    public function up()
    {
        // Tabel relasi penyakit-obat
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
            'id_obat' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'prioritas' => [
                'type'       => 'INT',
                'constraint' => 2,
                'default'    => 1,
                'comment'    => 'Urutan prioritas rekomendasi (1=tertinggi)',
            ],
            'dosis_saran' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
                'comment'    => 'Contoh: 3x sehari 1 tablet',
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
        $this->forge->addForeignKey('id_obat', 'obat', 'id_obat', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rekomendasi_obat');

        // CATATAN: Data ini akan di-insert setelah ada data obat
        // Contoh insert manual (sesuaikan dengan id_obat yang ada):
        /*
        $data = [
            ['id_penyakit' => 1, 'id_obat' => 1, 'prioritas' => 1, 'dosis_saran' => '3x sehari 1 tablet', 'created_at' => date('Y-m-d H:i:s')],
            ['id_penyakit' => 1, 'id_obat' => 2, 'prioritas' => 2, 'dosis_saran' => '2x sehari', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('rekomendasi_obat')->insertBatch($data);
        */
    }

    public function down()
    {
        $this->forge->dropTable('rekomendasi_obat');
    }
}