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


public function existeSolapamiento(
    string $desde,
    ?string $hasta = null,
    ?int $idExcluir = null
): bool {
    $builder = $this->builder();

    $builder->where('activo', 1);

    if ($idExcluir !== null) {
        $builder->where('id !=', $idExcluir);
    }

    // Una tarifa existente se solapa si:
    // su inicio es anterior o igual al final de la nueva
    // y su final es posterior o igual al inicio de la nueva.
    $builder->where('vigente_desde <=', $hasta ?? '9999-12-31');

    $builder->groupStart()
        ->where('vigente_hasta >=', $desde)
        ->orWhere('vigente_hasta IS NULL', null, false)
        ->groupEnd();

    return $builder->countAllResults() > 0;
}
}