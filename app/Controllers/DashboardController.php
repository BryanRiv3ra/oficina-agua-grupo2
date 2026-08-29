<?php
namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ContadorModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $clienteModel   = new ClienteModel();
        $contadorModel  = new ContadorModel();

        return view('dashboard', [
            'titulo'          => 'Panel principal',
            'vistaActiva'     => 'panel',
            'totalClientes'   => $clienteModel->where('activo', 1)->countAllResults(),
            'totalContadores' => $contadorModel->where('activo', 1)->countAllResults(),
            'totalSectores'   => $contadorModel->select('sector')->where('activo', 1)->where('sector !=', '')->distinct()->countAllResults(),
        ]);
    }
}