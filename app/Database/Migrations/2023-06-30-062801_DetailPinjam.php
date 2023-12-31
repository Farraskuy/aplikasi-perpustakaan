<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailPinjam extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pinjam' => [
                'type'           => 'VARCHAR',
                'constraint'     => 255,
            ],
            'id_buku' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'kondisi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'NULL'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'NULL'       => true,
            ],
            'deleted_at' => [
                'type'       => 'DATETIME',
                'NULL'       => true,
            ],
        ]);
        $this->forge->addForeignKey('id_pinjam', 'pinjam', 'id_pinjam');
        $this->forge->createTable('detail_pinjam');
    }

    public function down()
    {
        $this->forge->dropTable('detail_pinjam');
    }
}
