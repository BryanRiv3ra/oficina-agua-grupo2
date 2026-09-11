<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RolesUsuariosSeeder extends Seeder
{
    public function run()
    {
        // Los 3 roles del sistema
        $roles = [
            ['nombre' => 'Administrador'],
            ['nombre' => 'Secretaria'],
            ['nombre' => 'Lector'],
        ];
        $this->db->table('roles')->insertBatch($roles);

        // Usuario administrador de prueba
        // Password: "Admin1234" (ya viene como hash bcrypt, nunca en texto plano)
        $this->db->table('usuarios')->insert([
            'rol_id'        => 1, // Administrador (el primero insertado arriba)
            'nombre'        => 'Administrador General',
            'email'         => 'admin@oficina-agua.local',
            'password_hash' => password_hash('Admin1234', PASSWORD_DEFAULT),
            'activo'        => 1,
        ]);
    }
}