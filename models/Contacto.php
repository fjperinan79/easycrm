<?php
class Contacto {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($nombre, $empresa, $telefono, $email) {
        $stmt = $this->conn->prepare("INSERT INTO contactos (nombre, empresa, telefono, email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $empresa, $telefono, $email);
        return $stmt->execute();
    }

    public function listar() {
        $result = $this->conn->query("SELECT c.nombre as nombre, empresa, telefono, email, direccion, notas, p.nombre as producto FROM contactos c left join productos p on c.producto_id = p.ID");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
