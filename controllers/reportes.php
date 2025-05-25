<?php
require_once '../config/conexion.php';
session_start();

$parametro = $_POST["parametro"] ?? '';
$resultado = [];

switch ($parametro) {
    case "clientes":
        $res = $conn->query("SELECT * FROM contactos");
        $resultado = $res->fetch_all(MYSQLI_ASSOC);
        break;

    case "productos":
        $res = $conn->query("SELECT * FROM productos");
        $resultado = $res->fetch_all(MYSQLI_ASSOC);
        break;

    case "tickets":
        $res = $conn->query("
            SELECT T.ID, T.titulo, T.estado, T.prioridad, C.nombre AS contacto, U.nombre AS asignado
            FROM tickets T
            LEFT JOIN contactos C ON T.contacto_id = C.ID
            LEFT JOIN usuarios U ON T.usuario_asignado = U.ID
            ORDER BY T.fecha_creacion DESC
        ");
        $resultado = $res->fetch_all(MYSQLI_ASSOC);
        break;

    case "interacciones":
        $res = $conn->query("
            SELECT I.ID, I.fecha, I.tipo_interaccion, C.nombre AS contacto, I.notas
            FROM interacciones I
            JOIN contactos C ON I.contacto_id = C.ID
            ORDER BY I.fecha DESC
        ");
        $resultado = $res->fetch_all(MYSQLI_ASSOC);
        break;

    case "mensajes":
        $res = $conn->query("
            SELECT nombre, apellidos, telefono, correo, asunto, mensaje, fecha_envio 
            FROM mensajes 
            ORDER BY fecha_envio DESC
        ");
        $resultado = $res->fetch_all(MYSQLI_ASSOC);
        break;

    default:
        $resultado = [];
        break;
}

$_SESSION["reportes"] = $resultado;
header("Location: ../views/reportes.php");
?>
