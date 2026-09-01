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

    public function obtenerEstadoCuenta()
    {
        $builder = $this->db->table('clientes c');
        $builder->select(
            'c.id, c.nombre,
            COUNT(l.id) AS total_lecturas,
            SUM(CASE WHEN l.id IS NOT NULL AND p.id IS NULL THEN 1 ELSE 0 END) AS lecturas_sin_pago'
        );
        $builder->join('contadores ct', 'ct.cliente_id = c.id', 'left');
        $builder->join('lecturas l', 'l.contador_id = ct.id', 'left');
        $builder->join('pagos p', 'p.lectura_id = l.id', 'left');
        $builder->groupBy('c.id, c.nombre');
        $builder->orderBy('c.nombre', 'ASC');

        $resultados = $builder->get()->getResultArray();

        foreach ($resultados as &$fila) {
        $fila['estado'] = ($fila['lecturas_sin_pago'] > 0) ? 'Pendiente' : 'Al día';
        }

        return $resultados;
    }
}