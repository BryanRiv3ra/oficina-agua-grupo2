<?php
namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\ContadorModel;
use Config\Database;

class DashboardController extends BaseController
{
    public function index()
    {
        $clienteModel   = new ClienteModel();
        $contadorModel  = new ContadorModel();
        $db             = Database::connect();

        // 🆕 Cuenta lecturas que todavía no tienen un pago asociado
        $lecturasPendientes = $db->table('lecturas l')
            ->select('l.id')
            ->join('pagos p', 'p.lectura_id = l.id', 'left')
            ->where('p.id', null)
            ->countAllResults();

        return view('dashboard', [
            'titulo'             => 'Panel principal',
            'vistaActiva'        => 'panel',
            'totalClientes'      => $clienteModel->where('activo', 1)->countAllResults(),
            'totalContadores'    => $contadorModel->where('activo', 1)->countAllResults(),
            'totalSectores'      => $contadorModel->select('sector')->where('activo', 1)->where('sector !=', '')->distinct()->countAllResults(),
            'lecturasPendientes' => $lecturasPendientes,
        ]);
    }
}