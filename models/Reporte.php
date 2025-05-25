<?php
class Reporte {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function obtener($tipo) {
        $tabla = $tipo === "productos" ? "productos" : "contactos";
        $res = $this->conn->query("SELECT * FROM $tabla");
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>
