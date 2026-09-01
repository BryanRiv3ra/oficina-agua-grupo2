<?php

namespace App\Models;

use CodeIgniter\Model;

class LecturaModel extends Model
{
    protected $table      = 'lecturas';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'contador_id',
        'usuario_lector_id',
        'periodo',
        'fecha_lectura',
        'lectura_anterior',
        'lectura_actual',
        'consumo',
        'tarifa_id',
        'monto',
    ];

    protected $useTimestamps = false;

    /**
     * Obtiene la última lectura registrada de un contador.
     */
    public function ultimaLectura(int $contadorId): ?array
    {
        $lectura = $this->where('contador_id', $contadorId)
            ->orderBy('fecha_lectura', 'DESC')
            ->orderBy('id', 'DESC')
            ->first();

        return $lectura ?: null;
    }

    /**
     * Verifica si un contador ya tiene lectura en un período.
     */
    public function existeEnPeriodo(int $contadorId, string $periodo): bool
    {
        return $this->where('contador_id', $contadorId)
            ->where('periodo', $periodo)
            ->countAllResults() > 0;
    }
}