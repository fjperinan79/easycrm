<?php
class Mensaje {
    private $conn;
    public function __construct($db) {
        $this->conn = $db;
    }

    public function enviar($nombre, $apellidos, $telefono, $correo, $asunto, $mensaje) {
        $stmt = $this->conn->prepare("INSERT INTO mensajes (nombre, apellidos, telefono, correo, asunto, mensaje) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombre, $apellidos, $telefono, $correo, $asunto, $mensaje);
        return $stmt->execute();
    }
}
?>
