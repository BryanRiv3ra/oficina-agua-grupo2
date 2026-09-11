<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTokenToPagosTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pagos', [
            'token' => [
                'type'       => 'VARCHAR',
                'constraint' => 32,
                'null'       => true,
                'after'      => 'observaciones',
                'comment'    => 'Token de idempotencia: evita registrar dos veces el mismo pago',
            ],
        ]);

        // El índice UNIQUE es la protección real: la base de datos rechaza un segundo
        // pago con el mismo token, sin importar el orden en que lleguen las peticiones.
        $this->db->query('ALTER TABLE `pagos` ADD UNIQUE KEY `uq_pagos_token` (`token`)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `pagos` DROP INDEX `uq_pagos_token`');
        $this->forge->dropColumn('pagos', 'token');
    }
}