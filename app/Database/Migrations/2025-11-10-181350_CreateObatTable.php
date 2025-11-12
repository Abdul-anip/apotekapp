<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateObatTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_obat' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama_obat' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => false,
            ],
            'category_id' => [
                'type'       => 'INT',
                'unsigned'   => true,      // ✅ PENTING
                'null'       => true,
            ],
            'harga_beli' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
            ],
            'harga_jual' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'null'       => false,
            ],
            'stok' => [
                'type'       => 'INT',
                'null'       => false,
            ],
            'tanggal_kadaluarsa' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'created_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
            'updated_at' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);

        $this->forge->addKey('id_obat', true);
        $this->forge->addForeignKey('category_id', 'kategori', 'id', 'CASCADE', 'SET NULL'); // ✅ Tambahkan FK
        $this->forge->createTable('obat');
    }

    public function down()
    {
        $this->forge->dropTable('obat');
    }
}
