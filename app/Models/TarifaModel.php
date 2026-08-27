<?php

namespace App\Models;

use CodeIgniter\Model;

class TarifaModel extends Model
{
    protected $table         = 'tarifas';
    protected $primaryKey    = 'id';
    protected $allowedFields = [
        'monto_por_unidad',
        'vigente_desde',
        'vigente_hasta',
        'activo',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'monto_por_unidad' => 'required|decimal',
        'vigente_desde'    => 'required|valid_date[Y-m-d]',
        'vigente_hasta'    => 'permit_empty|valid_date[Y-m-d]',
    ];

    protected $validationMessages = [
        'monto_por_unidad' => [
            'required' => 'El monto por unidad es obligatorio.',
            'decimal'  => 'El monto por unidad debe ser un valor decimal válido.',
        ],
        'vigente_desde' => [
            'required'   => 'La fecha de inicio es obligatoria.',
            'valid_date' => 'La fecha de inicio no es válida.',
        ],
        'vigente_hasta' => [
            'valid_date' => 'La fecha de finalización no es válida.',
        ],
    ];
}