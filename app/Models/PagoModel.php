<?php
namespace App\Models;

use CodeIgniter\Model;

class PagoModel extends Model
{
    protected $table         = 'pagos';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'lectura_id',
        'usuario_registro_id',
        'monto',
        'fecha_pago',
        'metodo',
        'numero_boleta',
        'observaciones',
        'token',
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'lectura_id' => 'required|is_natural_no_zero',
        'monto'      => 'required|decimal|greater_than[0]',
        'fecha_pago' => 'required|valid_date',
        'metodo'     => 'required|in_list[efectivo,deposito,transferencia]',
    ];

    protected $validationMessages = [
        'monto' => [
            'required'     => 'El monto del pago es obligatorio.',
            'greater_than' => 'El monto debe ser mayor que cero.',
        ],
        'fecha_pago' => [
            'required' => 'La fecha del pago es obligatoria.',
        ],
    ];

    /**
     * Busca un pago por su token de idempotencia.
     * Si devuelve algo, significa que ese formulario ya fue procesado antes.
     */
    public function buscarPorToken(string $token): ?array
    {
        return $this->where('token', $token)->first();
    }

    /**
     * Busca el pago de una lectura concreta (la tabla tiene UNIQUE en lectura_id,
     * así que como mucho hay uno).
     */
    public function buscarPorLectura(int $lecturaId): ?array
    {
        return $this->where('lectura_id', $lecturaId)->first();
    }

    /**
     * Lecturas que todavía no tienen pago registrado.
     * Trae el cliente, el número de registro del contador y el sector,
     * para que la secretaria pueda ubicar la lectura que le presentan en oficina.
     */
    public function lecturasPendientes(?string $busqueda = null): array
    {
        $builder = $this->db->table('lecturas l');
        $builder->select('l.id, l.periodo, l.fecha_lectura, l.consumo, l.monto,
                          c.nombre AS cliente, ct.numero_registro AS contador,
                          ct.sector');
        $builder->join('contadores ct', 'ct.id = l.contador_id', 'inner');
        $builder->join('clientes c', 'c.id = ct.cliente_id', 'inner');
        $builder->join('pagos p', 'p.lectura_id = l.id', 'left');
        $builder->where('p.id IS NULL');

        if ($busqueda !== null && $busqueda !== '') {
            $builder->groupStart()
                    ->like('c.nombre', $busqueda)
                    ->orLike('ct.numero_registro', $busqueda)
                    ->groupEnd();
        }

        $builder->orderBy('l.fecha_lectura', 'DESC');

        return $builder->get()->getResultArray();
    }
}