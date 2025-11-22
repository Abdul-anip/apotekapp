<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddKeuntunganToLaporanTransaksi extends Migration
{
    public function up()
    {
        $this->forge->addColumn('laporan_transaksi', [
            'keuntungan' => [
                'type' => 'DECIMAL',
                'constraint' => '15,2',
                'null' => false,
                'default' => 0,
                'after' => 'total_harga'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('laporan_transaksi', 'keuntungan');
    }
}