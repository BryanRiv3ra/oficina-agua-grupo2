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

    
/**
 * Guarda una lectura y calcula automáticamente
 * el consumo y el monto según la tarifa vigente.
 */
public function store()
{
    $contadorId = (int) $this->request->getPost('contador_id');
    $fecha      = trim((string) $this->request->getPost('fecha_lectura'));
    $actual     = $this->request->getPost('lectura_actual');

    if ($contadorId <= 0) {
        return redirect()
            ->to('/lecturas')
            ->with('error', 'Contador no válido.');
    }

    if ($fecha === '') {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'La fecha de lectura es obligatoria.');
    }

    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'La fecha de lectura no es válida.');
    }

    if ($actual === null || $actual === '') {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'La lectura actual es obligatoria.');
    }

    if (!is_numeric($actual)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'La lectura actual debe ser un número válido.');
    }

    $actual = (float) $actual;

    if ($actual < 0) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'La lectura actual no puede ser negativa.');
    }

    // Verificar que el contador exista y esté activo.
    $contador = $this->contadorModel
        ->where('id', $contadorId)
        ->where('activo', 1)
        ->first();

    if (!$contador) {
        return redirect()
            ->to('/lecturas')
            ->with('error', 'Contador no encontrado o inactivo.');
    }

    // El período corresponde al mes de la fecha de lectura.
    $periodo = date('Y-m', strtotime($fecha));

    // No permitir dos lecturas del mismo contador en el período.
    if ($this->lecturaModel->existeEnPeriodo($contadorId, $periodo)) {
        return redirect()
            ->to('/lecturas')
            ->with(
                'error',
                'Este contador ya tiene una lectura registrada para el período ' . $periodo . '.'
            );
    }

    // Obtener la última lectura registrada.
    $ultimaLectura = $this->lecturaModel
        ->ultimaLectura($contadorId);

    $anterior = $ultimaLectura
        ? (float) $ultimaLectura['lectura_actual']
        : 0;

    // La lectura actual no puede ser menor que la anterior.
    if ($actual < $anterior) {
        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                'La lectura actual no puede ser menor que la lectura anterior (' .
                $anterior .
                ').'
            );
    }

    // Buscar la tarifa vigente para la fecha indicada.
    $tarifa = $this->tarifaModel
        ->obtenerTarifaVigente($fecha);

    if (!$tarifa) {
        return redirect()
            ->back()
            ->withInput()
            ->with(
                'error',
                'No existe una tarifa vigente para la fecha de la lectura.'
            );
    }

    // Cálculo del consumo.
    $consumo = $actual - $anterior;

    // Cálculo del monto.
    $monto = $consumo * (float) $tarifa['monto_por_unidad'];

    // Usuario autenticado que registra la lectura.
    $usuarioId = (int) session('usuario_id');

    if ($usuarioId <= 0) {
        return redirect()
            ->to('/login')
            ->with('error', 'La sesión no es válida. Inicia sesión nuevamente.');
    }

    $datos = [
        'contador_id'       => $contadorId,
        'usuario_lector_id' => $usuarioId,
        'periodo'           => $periodo,
        'fecha_lectura'     => $fecha,
        'lectura_anterior'  => $anterior,
        'lectura_actual'    => $actual,
        'consumo'           => $consumo,
        'tarifa_id'         => (int) $tarifa['id'],
        'monto'             => $monto,
    ];

    if (!$this->lecturaModel->insert($datos)) {
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'No fue posible guardar la lectura.');
    }

    $lecturaId = $this->lecturaModel->getInsertID();

    return redirect()
        ->to('/recibo/' . $lecturaId)
        ->with(
            'mensaje',
            'Lectura registrada correctamente. Consumo: ' .
            number_format($consumo, 2) .
            ' m³. Monto: Q' .
            number_format($monto, 2)
        );
    }
}