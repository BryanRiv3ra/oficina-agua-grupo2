<?php
namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table         = 'usuarios';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['rol_id', 'nombre', 'email', 'password_hash', 'activo'];

    protected $useTimestamps = true;
    protected $createdField  = 'creado_en';
    protected $updatedField  = 'actualizado_en';

    /**
     * Busca un usuario por su correo y trae también el nombre del rol.
     * Devuelve null si no existe.
     */
    public function buscarPorEmail(string $email): ?array
    {
        return $this->select('usuarios.*, roles.nombre AS rol_nombre')
            ->join('roles', 'roles.id = usuarios.rol_id', 'inner')
            ->where('usuarios.email', $email)
            ->first();
    }
}