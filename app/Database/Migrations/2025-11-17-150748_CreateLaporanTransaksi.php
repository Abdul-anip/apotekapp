<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLaporanTransaksi extends Migration
{
    public function up()
    {
    $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'kode_transaksi' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],

            'total_harga' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],

            'bayar' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],

            'kembalian' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
            ],

            // Simpan daftar barang dalam bentuk JSON
            'items' => [
                'type' => 'TEXT',
            ],

            'tanggal' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('laporan_transaksi');
    }

    public function down()
    {
    $this->forge->dropTable('laporan_transaksi');
    }
}
