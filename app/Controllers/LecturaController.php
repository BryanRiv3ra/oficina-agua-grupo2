<?php

namespace App\Controllers;

use App\Models\ContadorModel;
use App\Models\LecturaModel;
use App\Models\TarifaModel;

class LecturaController extends BaseController
{
    protected ContadorModel $contadorModel;
    protected LecturaModel $lecturaModel;
    protected TarifaModel $tarifaModel;

    public function __construct()
    {
        $this->contadorModel = new ContadorModel();
        $this->lecturaModel  = new LecturaModel();
        $this->tarifaModel   = new TarifaModel();
    }

    /**
     * Lista los contadores que todavía no tienen lectura
     * en el período actual.
     */
    public function index()
    {
        $periodo = date('Y-m');

        $contadores = $this->contadorModel
            ->conCliente()
            ->where('contadores.activo', 1)
            ->findAll();

        $pendientes = [];

        foreach ($contadores as $contador) {
            if (!$this->lecturaModel->existeEnPeriodo(
                (int) $contador['id'],
                $periodo
            )) {
                $pendientes[] = $contador;
            }
        }

        return view('lecturas/index', [
            'titulo'      => 'Registro de lecturas',
            'vistaActiva' => 'lecturas',
            'periodo'     => $periodo,
            'contadores'  => $pendientes,
        ]);
    }

    /**
     * Muestra el formulario para registrar una lectura.
     */
    public function create(int $contadorId)
    {
        $contador = $this->contadorModel
            ->conCliente()
            ->where('contadores.id', $contadorId)
            ->where('contadores.activo', 1)
            ->first();

        if (!$contador) {
            return redirect()
                ->to('/lecturas')
                ->with('error', 'Contador no encontrado.');
        }

        $periodo = date('Y-m');

        if ($this->lecturaModel->existeEnPeriodo(
            $contadorId,
            $periodo
        )) {
            return redirect()
                ->to('/lecturas')
                ->with(
                    'error',
                    'Este contador ya tiene una lectura registrada en el período actual.'
                );
        }

        $ultimaLectura = $this->lecturaModel
            ->ultimaLectura($contadorId);

        $lecturaAnterior = $ultimaLectura
            ? (float) $ultimaLectura['lectura_actual']
            : 0;

        return view('lecturas/form', [
            'titulo'          => 'Registrar lectura',
            'vistaActiva'     => 'lecturas',
            'contador'        => $contador,
            'periodo'         => $periodo,
            'lecturaAnterior' => $lecturaAnterior,
        ]);
    }

    
}