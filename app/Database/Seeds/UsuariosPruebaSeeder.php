<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariosPruebaSeeder extends Seeder
{
    public function run()
    {
        $this->db->table('usuarios')->insert([
            'rol_id'        => 2, // Secretaria
            'nombre'        => 'Secretaria de Prueba',
            'email'         => 'secretaria@oficina-agua.local',
            'password_hash' => password_hash('Secretaria1234', PASSWORD_DEFAULT),
            'activo'        => 1,
        ]);

        $this->db->table('usuarios')->insert([
            'rol_id'        => 3, // Lector
            'nombre'        => 'Lector de Prueba',
            'email'         => 'lector@oficina-agua.local',
            'password_hash' => password_hash('Lector1234', PASSWORD_DEFAULT),
            'activo'        => 1,
        ]);
    }
}