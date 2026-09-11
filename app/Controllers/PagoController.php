<?php
namespace App\Controllers;

use App\Models\LecturaModel;
use App\Models\PagoModel;

class PagoController extends BaseController
{
    protected PagoModel $pagoModel;
    protected LecturaModel $lecturaModel;

    public function __construct()
    {
        $this->pagoModel    = new PagoModel();
        $this->lecturaModel = new LecturaModel();
    }

    /**
     * Lista las lecturas pendientes de pago, con buscador por cliente o contador.
     */
    public function index()
    {
        $busqueda = trim((string) $this->request->getGet('q'));

        return view('pagos/index', [
            'titulo'      => 'Registrar pago',
            'vistaActiva' => 'pago',
            'pendientes'  => $this->pagoModel->lecturasPendientes($busqueda),
            'busqueda'    => $busqueda,
        ]);
    }

    /**
     * Muestra el formulario para registrar el pago de una lectura.
     * Aquí se genera el token de idempotencia que viajará oculto en el formulario.
     */
    public function create(int $lecturaId)
    {
        $lectura = $this->lecturaModel->find($lecturaId);

        if ($lectura === null) {
            return redirect()->to('/pagos')->with('error', 'La lectura indicada no existe.');
        }

        // Si esa lectura ya está pagada, no tiene sentido mostrar el formulario.
        if ($this->pagoModel->buscarPorLectura($lecturaId) !== null) {
            return redirect()->to('/pagos')->with('mensaje', 'Esa lectura ya tiene su pago registrado.');
        }

        // Token único de este formulario. Se guarda también en sesión para poder
        // compararlo al recibir el envío.
        $token = bin2hex(random_bytes(16));
        session()->set('token_pago', $token);

        return view('pagos/form', [
            'titulo'      => 'Registrar pago',
            'vistaActiva' => 'pago',
            'lectura'     => $lectura,
            'token'       => $token,
        ]);
    }

    /**
     * Procesa el pago. Es idempotente: enviar dos veces el mismo formulario
     * (doble clic) registra un solo pago y muestra éxito las dos veces.
     */
    public function store()
    {
        $token = (string) $this->request->getPost('token');

        if ($token === '') {
            return redirect()->to('/pagos')->with('error', 'Formulario inválido, vuelve a intentarlo.');
        }

        // 1) ¿Este formulario ya se procesó antes? Entonces no se registra nada nuevo
        //    y se devuelve la misma respuesta de éxito.
        if ($this->pagoModel->buscarPorToken($token) !== null) {
            return redirect()->to('/pagos')
                ->with('mensaje', 'El pago ya había sido registrado correctamente.');
        }

         // 🆕 2) Validación condicional: depósito/transferencia requieren número de boleta.
        $metodo       = $this->request->getPost('metodo');
        $numeroBoleta = trim((string) $this->request->getPost('numero_boleta'));

        if (in_array($metodo, ['deposito', 'transferencia'], true) && $numeroBoleta === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'El número de boleta es obligatorio para pagos por depósito o transferencia.');
        }

        $datos = [
        'lectura_id'          => (int) $this->request->getPost('lectura_id'),
        'usuario_registro_id' => (int) session('usuario_id'),
        'monto'               => $this->request->getPost('monto'),
        'fecha_pago'          => $this->request->getPost('fecha_pago'),
        'metodo'              => $metodo,
        'numero_boleta'       => $numeroBoleta ?: null,
        'observaciones'       => $this->request->getPost('observaciones') ?: null,
        'token'               => $token,
        ];

        try {
            if (! $this->pagoModel->insert($datos)) {
                return redirect()->back()->withInput()
                    ->with('errores', $this->pagoModel->errors());
            }
        } catch (\Throwable $e) {
            if ($this->pagoModel->buscarPorToken($token) !== null
                || $this->pagoModel->buscarPorLectura($datos['lectura_id']) !== null) {
                return redirect()->to('/pagos')
                    ->with('mensaje', 'El pago ya había sido registrado correctamente.');
            }

            throw $e;
        }

        session()->remove('token_pago');

        return redirect()->to('/pagos')->with('mensaje', 'Pago registrado correctamente.');
    }
}