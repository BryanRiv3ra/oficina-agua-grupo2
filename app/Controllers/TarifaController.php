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

    if ($desde && $this->tarifaModel->existeSolapamiento($desde, $hasta)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', [
                'El período de vigencia de la tarifa se solapa con otra tarifa existente.'
            ]);
    }

    if (!$this->tarifaModel->save($datos)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->tarifaModel->errors());
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

    if ($desde && $this->tarifaModel->existeSolapamiento($desde, $hasta, (int) $id)) {
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