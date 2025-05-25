<?php
require_once '../config/conexion.php';
require_once '../models/Ticket.php';

$modelo = new Ticket($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = trim($_POST["titulo"]);
    $descripcion = trim($_POST["descripcion"]);
    $contacto_id = intval($_POST["contacto_id"]);
    $usuario_asignado = empty($_POST["usuario_asignado"]) ? null : intval($_POST["usuario_asignado"]);
    $estado = $_POST["estado"];
    $prioridad = $_POST["prioridad"];

    if (isset($_POST["id"])) {
        $id = intval($_POST["id"]);
        $modelo->actualizar($id, $titulo, $descripcion, $contacto_id, $usuario_asignado, $estado, $prioridad);
        header("Location: ../views/tickets.php?editado=1");
    } else {
        $modelo->crear($titulo, $descripcion, $contacto_id, $usuario_asignado, $estado, $prioridad);
        header("Location: ../views/tickets.php?success=1");
    }
}
?>
