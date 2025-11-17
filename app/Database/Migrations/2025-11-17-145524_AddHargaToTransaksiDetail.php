<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddHargaToTransaksiDetail extends Migration
{
    public function up()
    {
        $this->forge->addColumn('transaksi_detail', [
        'harga' => [
            'type' => 'DECIMAL',
            'constraint' => '15,2',
            'null' => false,
            'after' => 'jumlah'
        ]
    ]);
    }

    public function down()
    {
        $this->forge->dropColumn('transaksi_detail', 'harga');

    }
}
