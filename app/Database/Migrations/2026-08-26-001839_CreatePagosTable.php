<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagosTable extends Migration
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
            'lectura_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => false,
            ],
            'usuario_registro_id' => [
                'type'       => 'INT',
                'constraint' => 5,
                'unsigned'   => true,
                'null'       => false,
                'comment'    => 'Secretaria que registro el pago',
            ],
            'monto' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => false,
            ],
            'fecha_pago' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'metodo' => [
                'type'       => 'ENUM',
                'constraint' => ['efectivo', 'deposito', 'transferencia'],
                'null'       => false,
                'default'    => 'efectivo',
            ],
            'numero_boleta' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'No. de boleta de deposito bancario, si aplica',
            ],
            'observaciones' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'creado_en' => [
                'type'    => 'TIMESTAMP',
                'null'    => false,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('lectura_id', 'uq_pagos_lectura');
        $this->forge->addForeignKey('lectura_id', 'lecturas', 'id', 'CASCADE', 'RESTRICT', 'fk_pagos_lectura');
        $this->forge->addForeignKey('usuario_registro_id', 'usuarios', 'id', 'CASCADE', 'RESTRICT', 'fk_pagos_usuario_registro');
        $this->forge->createTable('pagos');
    }

    public function down()
    {
        $this->forge->dropTable('pagos');
    }
}