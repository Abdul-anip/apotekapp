<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMerkToObat extends Migration
{
    public function up()
    {
        $this->forge->addColumn('obat', [
            'merk' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
                'after' => 'nama_obat'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropTable('obat');
    }
}
