<?php
class Interaccion {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function insertar($contacto_id, $tipo_interaccion, $notas) {
        $stmt = $this->conn->prepare(
            "INSERT INTO interacciones (contacto_id, tipo_interaccion, notas) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iss", $contacto_id, $tipo_interaccion, $notas);
        return $stmt->execute();
    }
}

?>
