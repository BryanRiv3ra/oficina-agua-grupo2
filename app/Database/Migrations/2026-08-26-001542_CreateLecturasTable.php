<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLecturasTable extends Migration
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
            'contador_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => false,
            ],
            'usuario_lector_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => false,
                'comment'    => 'Quien tomo la lectura',
            ],
            'periodo' => [
                'type'       => 'CHAR',
                'constraint' => 7,
                'null'       => false,
                'comment'    => 'Formato YYYY-MM',
            ],
            'fecha_lectura' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'lectura_anterior' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned'   => true,
                'null'       => false,
                'default'    => 0,
            ],
            'lectura_actual' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned'   => true,
                'null'       => false,
            ],
            'consumo' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'unsigned'   => true,
                'null'       => false,
                'comment'    => 'en m3',
            ],
            'tarifa_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => false,
            ],
            'monto' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'creado_en' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey(['contador_id', 'periodo'], 'uq_lecturas_contador_periodo');
        $this->forge->addKey('periodo');
        $this->forge->addForeignKey('contador_id', 'contadores', 'id', 'CASCADE', 'RESTRICT', 'fk_lecturas_contador');
        $this->forge->addForeignKey('usuario_lector_id', 'usuarios', 'id', 'CASCADE', 'RESTRICT', 'fk_lecturas_usuario_lector');
        $this->forge->addForeignKey('tarifa_id', 'tarifas', 'id', 'CASCADE', 'RESTRICT', 'fk_lecturas_tarifa');
        $this->forge->createTable('lecturas');
    }

    public function down()
    {
        $this->forge->dropTable('lecturas');
    }
}