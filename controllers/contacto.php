<?php
require_once '../config/conexion.php';
require_once '../models/Mensaje.php';
$modelo = new Mensaje($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $modelo->enviar($_POST["nombre"], $_POST["apellidos"], $_POST["telefono"], $_POST["correo"], $_POST["asunto"], $_POST["mensaje"]);
    header("Location: ../views/contacto.php?success=1");
}
?>
