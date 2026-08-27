<?php
namespace App\Controllers;

use App\Models\ClienteModel;

class ClienteController extends BaseController
{
    protected ClienteModel $clienteModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
    }

    // Listado + buscador
    public function index()
    {
        $buscar = $this->request->getGet('q');

        $query = $this->clienteModel->where('activo', 1)->orderBy('nombre', 'ASC');
        if (!empty($buscar)) {
            $query->like('nombre', $buscar);
        }

        return view('clientes/index', [
            'titulo'      => 'Clientes',
            'vistaActiva' => 'clientes',
            'clientes'    => $query->findAll(),
            'buscar'      => $buscar,
        ]);
    }

    // Formulario de creación
    public function create()
    {
        return view('clientes/form', [
            'titulo'      => 'Nuevo cliente',
            'vistaActiva' => 'clientes',
            'cliente'     => null,
        ]);
    }

    // Guardar cliente nuevo
    public function store()
    {
        if (!$this->clienteModel->save($this->request->getPost())) {
            return redirect()->back()->withInput()
                ->with('errors', $this->clienteModel->errors());
        }

        return redirect()->to('/clientes')->with('mensaje', 'Cliente creado correctamente.');
    }

    // Formulario de edición
    public function edit($id)
    {
        $cliente = $this->clienteModel->find($id);
        if (!$cliente) {
            return redirect()->to('/clientes')->with('error', 'Cliente no encontrado.');
        }

        return view('clientes/form', [
            'titulo'      => 'Editar cliente',
            'vistaActiva' => 'clientes',
            'cliente'     => $cliente,
        ]);
    }

    // Actualizar cliente
    public function update($id)
    {
        if (!$this->clienteModel->update($id, $this->request->getPost())) {
            return redirect()->back()->withInput()
                ->with('errors', $this->clienteModel->errors());
        }

        return redirect()->to('/clientes')->with('mensaje', 'Cliente actualizado correctamente.');
    }

    // Desactivar (soft delete) en vez de borrar físico
    public function delete($id)
    {
        $this->clienteModel->update($id, ['activo' => 0]);
        return redirect()->to('/clientes')->with('mensaje', 'Cliente desactivado.');
    }

    public function reactivar($id)
{
    $this->clienteModel->update($id, ['activo' => 1]);
    return redirect()->to('/clientes/desactivados')->with('mensaje', 'Cliente reactivado.');
}

    public function desactivados()
    {
        $buscar = $this->request->getGet('q');

        $query = $this->clienteModel->where('activo', 0)->orderBy('nombre', 'ASC');
        if (!empty($buscar)) {
            $query->like('nombre', $buscar);
        }

        return view('clientes/desactivados', [
            'titulo'      => 'Clientes desactivados',
            'vistaActiva' => 'clientes',
            'clientes'    => $query->findAll(),
            'buscar'      => $buscar,
        ]);
    }
}