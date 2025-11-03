<?php
class Token
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT t.*, c.razon_social 
                                   FROM tokens t 
                                   JOIN client_api c ON c.id = t.id_cliente
                                   ORDER BY t.id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($idCliente)
    {
        $random = bin2hex(random_bytes(10));
        $fechaForToken = date("Ymd");
        $fechaRegistro = date("Y-m-d H:i:s");

        $token = "{$random}-{$fechaForToken}-{$idCliente}";

        $stmt = $this->pdo->prepare("
            INSERT INTO tokens (id_cliente, token, fecha_registro, estado)
            VALUES (:id_cliente, :token, :fecha_registro, 1)
        ");
        $stmt->execute([
            ':id_cliente' => $idCliente,
            ':token' => $token,
            ':fecha_registro' => $fechaRegistro
        ]);
    }
}
