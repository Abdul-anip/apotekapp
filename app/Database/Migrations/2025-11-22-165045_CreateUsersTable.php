<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsersTable extends Migration
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
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'nama_lengkap' => [
                'type'       => 'VARCHAR',
                'constraint' => '150',
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['pemilik', 'kasir'],
                'default'    => 'kasir',
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
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
        $this->forge->createTable('users');

        // Insert default users
        $data = [
            [
                'username'     => 'pemilik',
                'password'     => password_hash('pemilik123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Pemilik Apotek',
                'role'         => 'pemilik',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
            ],
            [
                'username'     => 'kasir',
                'password'     => password_hash('kasir123', PASSWORD_DEFAULT),
                'nama_lengkap' => 'Kasir Apotek',
                'role'         => 'kasir',
                'is_active'    => 1,
                'created_at'   => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}