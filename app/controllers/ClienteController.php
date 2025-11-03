<?php
require_once __DIR__ . '/../models/Cliente.php';

class ClienteController
{
    private $model;

    public function __construct($pdo)
    {
        $this->model = new Cliente($pdo);
    }

    public function index()
    {
        $clientes = $this->model->getAll();
        include __DIR__ . '/../views/lista_clientes.php';
    }

    public function createForm()
    {
        include __DIR__ . '/../views/form_cliente.php';
    }

    public function store($data)
    {
        $this->model->create([
            'ruc' => $data['ruc'],
            'razon_social' => $data['razon_social'],
            'telefono' => $data['telefono'],
            'correo' => $data['correo'],
            'estado' => isset($data['estado']) ? (int)$data['estado'] : 1
        ]);

        header("Location: index.php?action=clientes");
        exit;
    }
}
