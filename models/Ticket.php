<?php
class Ticket {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function crear($titulo, $descripcion, $contacto_id, $usuario_asignado, $estado, $prioridad) {
        $stmt = $this->conn->prepare(
            "INSERT INTO tickets (titulo, descripcion, contacto_id, usuario_asignado, estado, prioridad)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssiiss", $titulo, $descripcion, $contacto_id, $usuario_asignado, $estado, $prioridad);
        return $stmt->execute();
    }

    public function actualizar($id, $titulo, $descripcion, $contacto_id, $usuario_asignado, $estado, $prioridad) {
        $stmt = $this->conn->prepare(
            "UPDATE tickets SET titulo=?, descripcion=?, contacto_id=?, usuario_asignado=?, estado=?, prioridad=? WHERE ID=?"
        );
        $stmt->bind_param("ssiissi", $titulo, $descripcion, $contacto_id, $usuario_asignado, $estado, $prioridad, $id);
        return $stmt->execute();
    }

    public function obtenerPorID($id) {
        $stmt = $this->conn->prepare("SELECT * FROM tickets WHERE ID = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function listar() {
        $sql = "SELECT T.*, C.nombre AS contacto, U.nombre AS asignado
                FROM tickets T
                LEFT JOIN contactos C ON T.contacto_id = C.ID
                LEFT JOIN usuarios U ON T.usuario_asignado = U.ID
                ORDER BY T.fecha_creacion DESC";
        $res = $this->conn->query($sql);
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
?>
