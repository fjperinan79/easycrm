<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../config/conexion.php';
session_start();

// Verificar que se envían email y password
if (!isset($_POST["email"], $_POST["password"])) {
    header("Location: ../views/login.php");
    exit();
}

$email = $_POST["email"];
$password = $_POST["password"];

// Preparar la consulta y validar que funcione
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ? AND password = ?");
if (!$stmt) {
    die("Error en prepare: " . $conn->error);
}

$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 1) {
    $usuario = $res->fetch_assoc();
    $_SESSION["usuario"] = $usuario["nombre"];
    $_SESSION["id"] = $usuario["ID"];
    $_SESSION["rol"] = $usuario["rol"];

    if ($_SESSION["rol"] === "admin") {
        header("Location: ../views/panel.php");
    } else {
        header("Location: ../views/inicio_usuario.php");
    }
} else {
    header("Location: ../views/login.php?error=1");
}
?>
