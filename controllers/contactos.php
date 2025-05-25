<?php
require_once '../config/conexion.php';
require_once '../models/Contacto.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$contacto = new Contacto($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $empresa = trim($_POST["empresa"]);
    $telefono = trim($_POST["telefono"]);
    $email = trim($_POST["email"]);
    $direccion = trim($_POST["direccion"]);
    $notas = trim($_POST["notas"]);
    $producto_id = intval($_POST["producto_id"]);

    $params = "&nombre=" . urlencode($nombre) . "&empresa=" . urlencode($empresa) .
              "&telefono=" . urlencode($telefono) . "&email=" . urlencode($email) .
              "&direccion=" . urlencode($direccion) . "&notas=" . urlencode($notas);

    if (empty($nombre) || empty($email)) {
        header("Location: ../views/contactos.php?error=missing" . $params);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../views/contactos.php?error=invalid_email" . $params);
        exit();
    }

    $res = $conn->prepare("SELECT id FROM Contactos WHERE email = ?");
    $res->bind_param("s", $email);
    $res->execute();
    $res->store_result();
    if ($res->num_rows > 0) {
        header("Location: ../views/contactos.php?error=duplicate" . $params);
        exit();
    }

    if (empty($_POST['producto_id']) || $_POST['producto_id'] === '0') {
        header("Location: ../views/contactos.php?error=missing_product" . $params);
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO Contactos (nombre, empresa, telefono, email, direccion, notas, producto_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $nombre, $empresa, $telefono, $email, $direccion, $notas, $producto_id);
    $stmt->execute();
    header("Location: ../views/contactos.php?success=1");
}
?>
