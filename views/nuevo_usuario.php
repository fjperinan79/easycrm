<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Crear nuevo usuario</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo">Crear nuevo usuario</h2>

    <form method="POST" action="../controllers/usuario.php" class="form">
        <input name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>" required class="form__field">
        <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>" required class="form__field">
        <input type="password" name="password" placeholder="Contraseña" required class="form__field">
        <select name="rol" class="form__field" required>
            <option value="usuario" <?= (($_GET['rol'] ?? '') === 'usuario') ? 'selected' : '' ?>>Usuario</option>
            <option value="admin" <?= (($_GET['rol'] ?? '') === 'admin') ? 'selected' : '' ?>>Administrador</option>
        </select>
        <button type="submit" name="accion" value="crear" class="btn">Crear usuario</button>
    </form>
</section>

<?php if (isset($_GET['error'])): ?>
<script>
alert("<?= match ($_GET['error']) {
    'missing' => 'Debes completar el nombre y el correo.',
    'invalid_email' => 'El correo no es válido.',
    'duplicate' => 'Ya existe un usuario con ese correo.',
    default => 'Error al guardar el contacto.'
} ?>");
</script>
<?php elseif (isset($_GET['success'])): ?>
<script>alert("Usuario creado correctamente.");</script>
<?php endif; ?>

</body>
</html>
