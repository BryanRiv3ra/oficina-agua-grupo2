<?php
namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nombre', 'telefono', 'direccion_principal', 'activo'];
    protected $useTimestamps    = true;
    protected $createdField     = 'creado_en';
    protected $updatedField     = 'actualizado_en';

    protected $validationRules = [
        'nombre'               => 'required|min_length[3]|max_length[150]',
        'direccion_principal'  => 'required|min_length[5]',
        'telefono'             => 'permit_empty|max_length[20]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del cliente es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
        ],
        'direccion_principal' => [
            'required' => 'La dirección principal es obligatoria.',
        ],
    ];
}