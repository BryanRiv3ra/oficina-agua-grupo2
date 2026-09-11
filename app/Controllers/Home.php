<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Portada pública del sistema. Si ya hay sesión activa,
     * no tiene sentido mostrarla: se entra directo al panel.
     */
    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session('logueado')) {
            return redirect()->to('/dashboard');
        }

        return view('bienvenida');
    }
}