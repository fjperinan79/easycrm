<?php
require_once '../config/conexion.php';
require_once '../models/Usuario.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$modelo = new Usuario($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'crear') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $params = "&nombre=" . urlencode($nombre) . "&email=" . urlencode($email) . "&rol=" . urlencode($rol);


    $res = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $res->bind_param("s", $email);
    $res->execute();
    $res->store_result();
    if ($res->num_rows > 0) {
        header("Location: ../views/nuevo_usuario.php?error=duplicate" . $params);
        exit();
    }

    if (empty($nombre) || empty($email)) {
        header("Location: ../views/nuevo_usuario.php?error=missing" . $params);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../views/nuevo_usuario.php?error=invalid_email" . $params);
        exit();
    }

    $modelo->crear($nombre, $email, $password, $rol);
    header("Location: ../views/nuevo_usuario.php?success=1");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'actualizar') {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $rol = $_POST['rol'];
    $password = $_POST['password'];

    $params = "&nombre=" . urlencode($nombre) . "&email=" . urlencode($email) . "&rol=" . urlencode($rol) . "&id=" . urlencode($id);

    if (empty($nombre) || empty($email)) {
        header("Location: ../views/editar_usuario.php?error=missing" . $params);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../views/editar_usuario.php?error=invalid_email" . $params);
        exit();
    }

    // Verificar si hay nueva contraseña
    $password_hash = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : null;

    $modelo->actualizar($id, $nombre, $email, $rol, $password_hash);
    header("Location: ../views/usuarios.php?mensaje=actualizado");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'eliminar') {
    $id = $_POST['id'];

    if (!empty($id)) {
        $modelo->eliminar($id);
        header("Location: ../views/usuarios.php?success=1");
        exit();
    } else {
        header("Location: ../views/usuarios.php?error=id_vacio");
        exit();
    }
}
