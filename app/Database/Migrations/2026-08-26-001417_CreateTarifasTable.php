<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTarifasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 5,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'monto_por_unidad' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
                'comment'    => 'Precio por m3 de consumo',
            ],
            'vigente_desde' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'vigente_hasta' => [
                'type'    => 'DATE',
                'null'    => true,
                'comment' => 'NULL = todavia vigente',
            ],
            'activo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'default'    => 1,
            ],
            'creado_en' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addKey(['vigente_desde', 'vigente_hasta']);
        $this->forge->createTable('tarifas');
    }

    public function down()
    {
        $this->forge->dropTable('tarifas');
    }
}