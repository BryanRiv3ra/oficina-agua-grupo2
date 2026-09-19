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

        $lecturasPendientes = $db->table('lecturas l')
            ->select('l.id')
            ->join('pagos p', 'p.lectura_id = l.id', 'left')
            ->where('p.id', null)
            ->countAllResults();

        // Clima de Jutiapa. Si la API no responde, queda en null.
        $clima = null;
        $url = 'https://api.open-meteo.com/v1/forecast?latitude=14.2911&longitude=-89.8958&current=temperature_2m&timezone=America/Guatemala';
        $respuesta = @file_get_contents($url, false, stream_context_create(['http' => ['timeout' => 4]]));

        if ($respuesta !== false) {
            $datos = json_decode($respuesta, true);
            if (isset($datos['current']['temperature_2m'])) {
                $clima = round((float) $datos['current']['temperature_2m']);
            }
        }

        return view('dashboard', [
            'titulo'             => 'Panel principal',
            'vistaActiva'        => 'panel',
            'totalClientes'      => $clienteModel->where('activo', 1)->countAllResults(),
            'totalContadores'    => $contadorModel->where('activo', 1)->countAllResults(),
            'totalSectores'      => $contadorModel->select('sector')->where('activo', 1)->where('sector !=', '')->distinct()->countAllResults(),
            'lecturasPendientes' => $lecturasPendientes,
            'clima'              => $clima,
        ]);
    }
}