<?php
require_once '../config/conexion.php';
require_once '../models/Interaccion.php';

$interaccion = new Interaccion($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $contacto_id = intval($_POST["contacto_id"]);
    $tipo = trim($_POST["tipo_interaccion"]);
    $notas = trim($_POST["notas"]);

    if (empty($contacto_id) || empty($tipo)) {
        header("Location: ../views/interacciones.php?error=missing");
        exit();
    }

    $interaccion->insertar($contacto_id, $tipo, $notas);

    header("Location: ../views/interacciones.php?success=1");
    exit();
}

?>

