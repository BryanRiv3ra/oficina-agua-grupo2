<?php
namespace App\Controllers;

use App\Models\ClienteModel;

class EstadoCuentaController extends BaseController
{
    protected ClienteModel $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    public function index()
    {
        $filtro = $this->request->getGet('estado'); // 'pendiente', 'al_dia', o vacío (todos)

        $clientes = $this->clienteModel->obtenerEstadoCuenta();

        if ($filtro === 'pendiente') {
            $clientes = array_filter($clientes, fn($c) => $c['estado'] === 'Pendiente');
        } elseif ($filtro === 'al_dia') {
            $clientes = array_filter($clientes, fn($c) => $c['estado'] === 'Al día');
        }

        return view('estado_cuenta/index', [
            'titulo'      => 'Estado de Cuenta',
            'vistaActiva' => 'estado_cuenta',
            'clientes'    => $clientes,
            'filtro'      => $filtro,
        ]);
    }
}