<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTokenToClientesYContadores extends Migration
{
    public function up()
    {
        $this->forge->addColumn('clientes', [
            'token' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'unique' => true, 'after' => 'activo'],
        ]);
        $this->forge->addColumn('contadores', [
            'token' => ['type' => 'VARCHAR', 'constraint' => 64, 'null' => true, 'unique' => true, 'after' => 'activo'],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('clientes', 'token');
        $this->forge->dropColumn('contadores', 'token');
    }
}