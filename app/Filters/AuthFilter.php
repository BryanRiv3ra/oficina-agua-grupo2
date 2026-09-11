<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filtro de sesión: si no hay sesión iniciada, manda al login.
 * Se aplica a todas las rutas protegidas (ver app/Config/Filters.php).
 */
class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (! session('logueado')) {
            return redirect()->to('/login')
                ->with('error', 'Debes iniciar sesión para entrar al sistema.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita nada después de la respuesta.
    }
}