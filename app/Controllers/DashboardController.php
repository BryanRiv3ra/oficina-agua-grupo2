<?php
namespace App\Controllers;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('dashboard', [
            'titulo' => 'Panel principal',
            'vistaActiva' => 'panel',
        ]);
    }
}