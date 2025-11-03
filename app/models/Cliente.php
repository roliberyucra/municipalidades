<?php
class Cliente
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM client_api ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO client_api (ruc, razon_social, telefono, correo, fecha_registro, estado)
            VALUES (:ruc, :razon_social, :telefono, :correo, NOW(), :estado)
        ");
        return $stmt->execute($data);
    }
}
