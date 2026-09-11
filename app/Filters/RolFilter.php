<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Filtro de roles. Se usa como 'rol:Administrador' o 'rol:Administrador,Secretaria'.
 * Los nombres que van después de los dos puntos llegan aquí en $arguments
 * y deben escribirse igual que en la tabla `roles`.
 */
class RolFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Sin sesión: primero al login (aunque el AuthFilter normalmente ya lo atrapó).
        if (! session('logueado')) {
            return redirect()->to('/login')
                ->with('error', 'Debes iniciar sesión para entrar al sistema.');
        }

        $rolEnSesion = (string) session('rol');
        $permitidos  = $arguments ?? [];

        if ($permitidos !== [] && ! in_array($rolEnSesion, $permitidos, true)) {
            return redirect()->to('/dashboard')
                ->with('error', 'Tu rol (' . esc($rolEnSesion) . ') no tiene acceso a esa sección.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita nada después de la respuesta.
    }
}