<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterProdukTable extends Migration
{
    public function up()
    {
        $this->forge->dropForeignKey('produk', 'produk_kategori_id_foreign');

        $this->forge->dropColumn('produk', ['status', 'kategori_id']);

        $this->forge->addColumn('produk', [
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'after' => 'nama',
            ],
            'image' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'deskripsi',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('produk', ['kategori', 'image']);

        $this->forge->addColumn('produk', [
            'kategori_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'after' => 'produk_id',
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['active', 'inactive', 'out_of_stock'],
                'default' => 'active',
                'after' => 'rating',
            ],
        ]);

        $this->forge->addForeignKey('kategori_id', 'kategori', 'kategori_id', 'CASCADE', 'CASCADE');
    }
}
