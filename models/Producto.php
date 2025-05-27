<?php
class Producto {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($nombre, $categoria) {
        $stmt = $this->conn->prepare("INSERT INTO productos (nombre, tipo_producto, fecha_alta) VALUES (?, ?, NOW())");
        $stmt->bind_param("ss", $nombre, $categoria);
        return $stmt->execute();
    }

    public function listar() {
        $res = $this->conn->query("SELECT * FROM productos");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>
