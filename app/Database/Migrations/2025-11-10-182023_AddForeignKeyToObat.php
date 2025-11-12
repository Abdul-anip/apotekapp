<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeyToObat extends Migration
{
    public function up()
    {
        $this->forge->addColumn('obat', [
         'CONSTRAINT fk_kategori FOREIGN KEY(category_id) REFERENCES kategori(id) ON DELETE SET NULL'
        ]);
    }

    public function down()
    {
         $this->forge->dropForeignKey('obat', 'fk_kategori');

    }
}
