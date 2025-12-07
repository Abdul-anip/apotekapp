<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatKonsultasiTable extends Migration
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
            'kode_konsultasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'unique'     => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'comment'    => 'ID kasir yang melakukan konsultasi',
            ],
            'gejala_input' => [
                'type'    => 'TEXT',
                'comment' => 'JSON array id gejala yang dipilih',
            ],
            'hasil_diagnosa' => [
                'type'    => 'TEXT',
                'comment' => 'JSON hasil diagnosa dengan CF',
            ],
            'obat_direkomendasikan' => [
                'type'    => 'TEXT',
                'null'    => true,
                'comment' => 'JSON array id obat yang direkomendasikan',
            ],
            'tanggal_konsultasi' => [
                'type' => 'DATETIME',
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
        $this->forge->addForeignKey('id_user', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('riwayat_konsultasi');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_konsultasi');
    }
}