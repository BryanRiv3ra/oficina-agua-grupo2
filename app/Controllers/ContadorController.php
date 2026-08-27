<?php
namespace App\Controllers;

use App\Models\ContadorModel;
use App\Models\ClienteModel;

class ContadorController extends BaseController
{
    protected ContadorModel $contadorModel;
    protected ClienteModel $clienteModel;

    public function __construct()
    {
        $this->contadorModel = new ContadorModel();
        $this->clienteModel  = new ClienteModel();
    }

    public function index()
    {
        $buscar = $this->request->getGet('q');

        $query = $this->contadorModel->conCliente()->where('contadores.activo', 1)->orderBy('contadores.numero_registro', 'ASC');
        if (!empty($buscar)) {
            $query->groupStart()
                  ->like('contadores.numero_registro', $buscar)
                  ->orLike('clientes.nombre', $buscar)
                  ->groupEnd();
        }

        return view('contadores/index', [
            'titulo'      => 'Contadores',
            'vistaActiva' => 'contadores',
            'contadores'  => $query->findAll(),
            'buscar'      => $buscar,
        ]);
    }

    public function create()
    {
        return view('contadores/form', [
            'titulo'      => 'Nuevo contador',
            'vistaActiva' => 'contadores',
            'contador'    => null,
            'clientes'    => $this->clienteModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll(),
        ]);
    }

    public function store()
    {
        $this->contadorModel->setValidationRules($this->contadorModel->validationRules());

        if (!$this->contadorModel->save($this->request->getPost())) {
            return redirect()->back()->withInput()
                ->with('errors', $this->contadorModel->errors());
        }

        return redirect()->to('/contadores')->with('mensaje', 'Contador creado correctamente.');
    }

    public function edit($id)
    {
        $contador = $this->contadorModel->find($id);
        if (!$contador) {
            return redirect()->to('/contadores')->with('error', 'Contador no encontrado.');
        }

        return view('contadores/form', [
            'titulo'      => 'Editar contador',
            'vistaActiva' => 'contadores',
            'contador'    => $contador,
            'clientes'    => $this->clienteModel->where('activo', 1)->orderBy('nombre', 'ASC')->findAll(),
        ]);
    }

    public function update($id)
    {
        $this->contadorModel->setValidationRules($this->contadorModel->validationRules((int) $id));

        if (!$this->contadorModel->update($id, $this->request->getPost())) {
            return redirect()->back()->withInput()
                ->with('errors', $this->contadorModel->errors());
        }

        return redirect()->to('/contadores')->with('mensaje', 'Contador actualizado correctamente.');
    }

    public function delete($id)
    {
        $this->contadorModel->update($id, ['activo' => 0]);
        return redirect()->to('/contadores')->with('mensaje', 'Contador desactivado.');
    }

    public function desactivados()
    {
        $contadores = $this->contadorModel->conCliente()->where('contadores.activo', 0)->orderBy('contadores.numero_registro', 'ASC')->findAll();

        return view('contadores/desactivados', [
            'titulo'      => 'Contadores desactivados',
            'vistaActiva' => 'contadores',
            'contadores'  => $contadores,
        ]);
    }

    public function reactivar($id)
    {
        $this->contadorModel->update($id, ['activo' => 1]);
        return redirect()->to('/contadores/desactivados')->with('mensaje', 'Contador reactivado.');
    }
}