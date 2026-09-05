<?php
namespace App\Models;

use CodeIgniter\Model;

class ContadorModel extends Model
{
    protected $table            = 'contadores';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['cliente_id', 'numero_registro', 'direccion_servicio', 'sector', 'activo', 'token'];
    protected $useTimestamps    = true;
    protected $createdField     = 'creado_en';
    protected $updatedField     = 'actualizado_en';

    public function validationRules(int $idExcluir = null): array
    {
        $reglaUnico = 'is_unique[contadores.numero_registro]';
        if ($idExcluir) {
            $reglaUnico .= ',id,' . $idExcluir;
        }

        return [
            'cliente_id'          => 'required|is_natural_no_zero',
            'numero_registro'     => "required|min_length[2]|max_length[30]|{$reglaUnico}",
            'direccion_servicio'  => 'required|min_length[5]',
            'sector'              => 'permit_empty|max_length[100]',
        ];
    }

    protected $validationMessages = [
        'cliente_id' => [
            'required' => 'Debes seleccionar un cliente.',
        ],
        'numero_registro' => [
            'required'   => 'El número de registro es obligatorio.',
            'is_unique'  => 'Ese número de registro ya está en uso por otro contador.',
        ],
        'direccion_servicio' => [
            'required' => 'La dirección de servicio es obligatoria.',
        ],
    ];

    public function conCliente()
    {
        return $this->select('contadores.*, clientes.nombre as cliente_nombre')
                     ->join('clientes', 'clientes.id = contadores.cliente_id');
    }
}