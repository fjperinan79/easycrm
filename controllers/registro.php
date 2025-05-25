<?php
require_once '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST["nombre"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $repeat = $_POST["repeat"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../views/registro.php?error=invalid_email");
        exit();
    }

    if ($password !== $repeat) {
        header("Location: ../views/registro.php?error=nomatch");
        exit();
    }

    $check = $conn->prepare("SELECT id FROM Usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();
    if ($check->num_rows > 0) {
        header("Location: ../views/registro.php?error=duplicate");
        exit();
    }

    $stmt = $conn->prepare("INSERT INTO Usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'usuario')");
    $stmt->bind_param("sss", $nombre, $email, $password);
    if ($stmt->execute()) {
        header("Location: ../views/login.php?registro=1");
    } else {
        header("Location: ../views/registro.php?error=save");
    }
}
?>
