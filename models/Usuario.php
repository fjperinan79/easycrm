<?php
class Usuario {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function existeEmail($email) {
        $stmt = $this->conn->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows > 0;
    }

    public function crear($nombre, $email, $password, $rol) {
        $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $email, $password, $rol);
        $stmt->execute();
    }

    public function obtenerPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    public function actualizar($id, $nombre, $email, $rol, $password = null) {
        if ($password) {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ?, password = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $nombre, $email, $rol, $password, $id);
        } else {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol = ? WHERE id = ?");
            $stmt->bind_param("sssi", $nombre, $email, $rol, $id);
        }
        $stmt->execute();
    }

    public function listar() {
    $result = $this->conn->query("SELECT * FROM usuarios");
    return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function eliminar($id) {
    $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    }

}
?>