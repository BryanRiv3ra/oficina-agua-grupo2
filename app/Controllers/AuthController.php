<?php
namespace App\Controllers;

use App\Models\UsuarioModel;

class AuthController extends BaseController
{
    protected UsuarioModel $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    /**
     * Muestra el formulario de login.
     * Si ya hay sesión activa, manda directo al panel.
     */
    public function login()
    {
        if (session('logueado')) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login', [
            'titulo' => 'Iniciar sesión',
        ]);
    }

    /**
     * Procesa el formulario: valida el usuario contra la tabla `usuarios`
     * y abre la sesión nativa de CI4 guardando el rol.
     */
    public function procesarLogin()
    {
        $email    = trim((string) $this->request->getPost('email'));
        $password = (string) $this->request->getPost('password');

        // Mensaje genérico a propósito: no se dice cuál de los dos campos falló.
        $mensajeGenerico = 'Usuario o contraseña incorrectos.';

        if ($email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', $mensajeGenerico);
        }

        $usuario = $this->usuarioModel->buscarPorEmail($email);

        // Usuario inexistente, desactivado o contraseña que no coincide: mismo mensaje.
        if ($usuario === null
            || (int) $usuario['activo'] !== 1
            || ! password_verify($password, (string) $usuario['password_hash'])) {
            return redirect()->back()->withInput()->with('error', $mensajeGenerico);
        }

        // Se regenera el ID de sesión para evitar fijación de sesión (session fixation).
        session()->regenerate();

        session()->set([
            'usuario_id' => (int) $usuario['id'],
            'nombre'     => $usuario['nombre'],
            'email'      => $usuario['email'],
            'rol_id'     => (int) $usuario['rol_id'],
            'rol'        => $usuario['rol_nombre'],
            'logueado'   => true,
        ]);

        return redirect()->to('/dashboard')
            ->with('mensaje', 'Bienvenido(a), ' . $usuario['nombre'] . '.');
    }

    /**
     * Destruye la sesión y regresa al login.
     */
    public function logout()
    {
        session()->destroy();

        return redirect()->to('/login')->with('mensaje', 'Sesión cerrada correctamente.');
    }
}