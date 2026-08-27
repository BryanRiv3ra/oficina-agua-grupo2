<?php

namespace App\Controllers;

use App\Models\TarifaModel;

class TarifaController extends BaseController
{
    protected TarifaModel $tarifaModel;

    public function __construct()
    {
        $this->tarifaModel = new TarifaModel();
    }

    /**
     * Listado histórico de tarifas
     */
    public function index()
    {
        $tarifas = $this->tarifaModel
            ->orderBy('vigente_desde', 'DESC')
            ->findAll();

        return view('tarifas/index', [
            'titulo'      => 'Tarifas',
            'vistaActiva' => 'tarifas',
            'tarifas'     => $tarifas,
        ]);
    }

    /**
     * Formulario para crear una tarifa
     */
    public function create()
    {
        return view('tarifas/form', [
            'titulo'      => 'Nueva tarifa',
            'vistaActiva' => 'tarifas',
            'tarifa'      => null,
        ]);
    }

    /**
     * Guardar una tarifa nueva
    */
    public function store()
{
    $datos = $this->request->getPost();

    $desde = $datos['vigente_desde'] ?? null;

    $hasta = !empty($datos['vigente_hasta'])
        ? $datos['vigente_hasta']
        : null;

    $datos['vigente_hasta'] = $hasta;

    // Validar fecha de inicio
    if (!$desde) {
        return redirect()->back()
            ->withInput()
            ->with('errors', [
                'La fecha de inicio es obligatoria.'
            ]);
    }

    // Validar que la fecha final no sea anterior a la inicial
    if ($hasta !== null && $hasta < $desde) {
        return redirect()->back()
            ->withInput()
            ->with('errors', [
                'La fecha de finalización debe ser igual o posterior a la fecha de inicio.'
            ]);
    }

    // Buscar la tarifa abierta anterior
    $tarifaAnterior = $this->tarifaModel
        ->obtenerTarifaAbiertaAnterior($desde);

    /*
     * Verificar solapamientos.
     *
     * Si existe una tarifa abierta anterior, se excluye porque
     * esa tarifa será cerrada automáticamente antes de guardar
     * la nueva.
     */
    $idExcluir = $tarifaAnterior
        ? (int) $tarifaAnterior['id']
        : null;

    if ($this->tarifaModel->existeSolapamiento(
        $desde,
        $hasta,
        $idExcluir
    )) {
        return redirect()->back()
            ->withInput()
            ->with('errors', [
                'El período de vigencia de la tarifa se solapa con otra tarifa existente.'
            ]);
    }

    $db = \Config\Database::connect();

    $db->transStart();

    // Cerrar automáticamente la tarifa abierta anterior
    if ($tarifaAnterior) {
        $fechaFinAnterior = date(
            'Y-m-d',
            strtotime($desde . ' -1 day')
        );

        $this->tarifaModel->update(
            $tarifaAnterior['id'],
            [
                'vigente_hasta' => $fechaFinAnterior,
            ]
        );
    }

    // Guardar la nueva tarifa
    if (!$this->tarifaModel->save($datos)) {
        $db->transRollback();

        return redirect()->back()
            ->withInput()
            ->with('errors', $this->tarifaModel->errors());
    }

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()
            ->withInput()
            ->with('errors', [
                'No fue posible guardar la tarifa.'
            ]);
    }

    return redirect()->to('/tarifas')
        ->with('mensaje', 'Tarifa creada correctamente.');
}

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $tarifa = $this->tarifaModel->find($id);

        if (!$tarifa) {
            return redirect()->to('/tarifas')
                ->with('error', 'Tarifa no encontrada.');
        }

        return view('tarifas/form', [
            'titulo'      => 'Editar tarifa',
            'vistaActiva' => 'tarifas',
            'tarifa'      => $tarifa,
        ]);
    }

    /**
    * Actualizar una tarifa
    */
    public function update($id)
{
    $datos = $this->request->getPost();

    $desde = $datos['vigente_desde'] ?? null;

    $hasta = !empty($datos['vigente_hasta'])
        ? $datos['vigente_hasta']
        : null;

    $datos['vigente_hasta'] = $hasta;

    // Validar fecha de inicio
    if (!$desde) {
        return redirect()->back()
            ->withInput()
            ->with('errors', [
                'La fecha de inicio es obligatoria.'
            ]);
    }

    // Validar que la fecha final no sea anterior a la inicial
    if ($hasta !== null && $hasta < $desde) {
        return redirect()->back()
            ->withInput()
            ->with('errors', [
                'La fecha de finalización debe ser igual o posterior a la fecha de inicio.'
            ]);
    }

    // Validar solapamiento con otras tarifas
    if ($this->tarifaModel->existeSolapamiento(
        $desde,
        $hasta,
        (int) $id
    )) {
        return redirect()->back()
            ->withInput()
            ->with('errors', [
                'El período de vigencia de la tarifa se solapa con otra tarifa existente.'
            ]);
    }

    if (!$this->tarifaModel->update($id, $datos)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->tarifaModel->errors());
    }

    return redirect()->to('/tarifas')
        ->with('mensaje', 'Tarifa actualizada correctamente.');
}
}