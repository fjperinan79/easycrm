<?php
require_once '../config/conexion.php';
require_once '../models/Producto.php';

$modelo = new Producto($conn);


if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["baja_id"])) {
    $id = intval($_POST["baja_id"]);
    $conn->query("UPDATE productos SET fecha_baja = CURDATE() WHERE ID = $id");
    header("Location: ../views/productos.php?baja=1");
    exit();
}


if (
    $_SERVER["REQUEST_METHOD"] === "POST" &&
    isset($_POST["nombre"], $_POST["categoria"])
) {
    $modelo->crear($_POST["nombre"], $_POST["categoria"]);
    header("Location: ../views/productos.php?success=1");
    exit();
}


header("Location: ../views/productos.php?error=missing");
exit();
?>
