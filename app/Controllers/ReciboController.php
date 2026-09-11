<?php
namespace App\Controllers;

use Config\Database;

class ReciboController extends BaseController
{
    public function ver($lecturaId)
    {
        $db = Database::connect();

        $recibo = $db->table('lecturas l')
            ->select('l.id, l.periodo, l.fecha_lectura, l.lectura_anterior, l.lectura_actual, l.consumo, l.monto,
                      l.contador_id,
                      c.nombre AS cliente_nombre, c.direccion_principal,
                      ct.numero_registro, ct.direccion_servicio, ct.sector,
                      t.monto_por_unidad,
                      u.nombre AS lector_nombre')
            ->join('contadores ct', 'ct.id = l.contador_id')
            ->join('clientes c', 'c.id = ct.cliente_id')
            ->join('tarifas t', 't.id = l.tarifa_id')
            ->join('usuarios u', 'u.id = l.usuario_lector_id')
            ->where('l.id', $lecturaId)
            ->get()
            ->getRowArray();

        if (! $recibo) {
            return redirect()->to('/lecturas')->with('error', 'Recibo no encontrado.');
        }

        // 🆕 Número secuencial de esta lectura, específico para este contador.
        $secuencia = $db->table('lecturas')
            ->where('contador_id', $recibo['contador_id'])
            ->where('id <=', $recibo['id'])
            ->countAllResults();

        $recibo['numero_recibo'] = $recibo['numero_registro'] . '-' . str_pad($secuencia, 4, '0', STR_PAD_LEFT);

        return view('recibos/ver', [
            'titulo' => 'Recibo de pago',
            'recibo' => $recibo,
        ]);
    }
}