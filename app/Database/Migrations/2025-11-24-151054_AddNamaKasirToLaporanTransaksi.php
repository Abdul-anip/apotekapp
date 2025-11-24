<?php

use CodeIgniter\Database\Migration;

class AddNamaKasirToLaporanTransaksi extends Migration
{
    public function up()
    {
        // Mendefinisikan kolom baru
        $fields = [
            'nama_kasir' => [
                'type'       => 'VARCHAR',
                'constraint' => '100', // Sesuaikan panjang sesuai kebutuhan
                'after'      => 'tanggal', // Tentukan setelah kolom mana (optional)
                'null'       => true,
            ],
        ];

        // Menambahkan kolom ke tabel laporan_transaksi
        $this->forge->addColumn('laporan_transaksi', $fields);
    }

    public function down()
    {
        // Menghapus kolom jika rollback
        $this->forge->dropColumn('laporan_transaksi', 'nama_kasir');
    }
}