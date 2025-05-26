<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}
require_once '../config/conexion.php';
require_once '../models/Usuario.php';

$modelo = new Usuario($conn);
$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: usuarios.php?error=id_faltante");
    exit();
}
$usuario = $modelo->obtenerPorId($id);
if (!$usuario) {
    header("Location: usuarios.php?error=usuario_no_encontrado");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar usuario</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo">Editar usuario</h2>

    <?php if (isset($_GET["error"]) && $_GET["error"] === "missing"): ?>
        <div class="mensaje mensaje--error">⚠️ Faltan campos obligatorios.</div>
    <?php elseif (isset($_GET["error"]) && $_GET["error"] === "invalid_email"): ?>
        <div class="mensaje mensaje--error">⚠️ El email no es válido.</div>
    <?php endif; ?>

    <form method="POST" action="../controllers/usuario.php" class="form">
        <input type="hidden" name="id" value="<?= $usuario["ID"] ?>">

        <input name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($usuario["nombre"]) ?>" required class="form__field">
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($usuario["email"]) ?>" required class="form__field">
        <input type="password" name="password" placeholder="Nueva contraseña (opcional)" class="form__field">

        <select name="rol" class="form__field" required>
            <option value="usuario" <?= $usuario["rol"] === "usuario" ? "selected" : "" ?>>Usuario</option>
            <option value="admin" <?= $usuario["rol"] === "admin" ? "selected" : "" ?>>Administrador</option>
            <option value="soporte" <?= $usuario["rol"] === "soporte" ? "selected" : "" ?>>Soporte</option>
        </select>

        <button type="submit" name="accion" value="actualizar" class="btn">Guardar cambios</button>
    </form>
</section>
</body>
</html>
