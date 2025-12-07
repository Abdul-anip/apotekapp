<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateGejalaTable extends Migration
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
            'kode_gejala' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'unique'     => true,
            ],
            'nama_gejala' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
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
        $this->forge->createTable('gejala');

        // Insert data gejala contoh
        $data = [
            ['kode_gejala' => 'G001', 'nama_gejala' => 'Demam tinggi (>38°C)', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G002', 'nama_gejala' => 'Batuk kering', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G003', 'nama_gejala' => 'Batuk berdahak', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G004', 'nama_gejala' => 'Pilek/hidung tersumbat', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G005', 'nama_gejala' => 'Sakit kepala', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G006', 'nama_gejala' => 'Nyeri tenggorokan', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G007', 'nama_gejala' => 'Mual/muntah', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G008', 'nama_gejala' => 'Diare', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G009', 'nama_gejala' => 'Nyeri perut', 'created_at' => date('Y-m-d H:i:s')],
            ['kode_gejala' => 'G010', 'nama_gejala' => 'Pusing/vertigo', 'created_at' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('gejala')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('gejala');
    }
}