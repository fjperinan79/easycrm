<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger' style='margin: 10px'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']);
}
?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/auth.php';
require_admin();

if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conexion.php';
require_once '../models/Contacto.php';

$modelo = new Contacto($conn);
$contactos = $modelo->listar();

$productos = $conn->query("SELECT ID, nombre FROM productos")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Contactos</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="form-signin w-100 m-auto section">
    <div class="titulo"><h1 class="h3 mb-3 fw-normal">Gestión de clientes</h1></div>
    <form method="POST" action="../controllers/contactos.php" class="form">
        <input type="text" name="nombre" placeholder="Nombre" required class="form__field" value="<?= htmlspecialchars($_GET['nombre'] ?? '') ?>">
        <input type="text" name="empresa" placeholder="Empresa" class="form__field" value="<?= htmlspecialchars($_GET['empresa'] ?? '') ?>">
        <input type="text" name="telefono" placeholder="Teléfono" class="form__field" value="<?= htmlspecialchars($_GET['telefono'] ?? '') ?>">
        <input type="email" name="email" placeholder="Correo electrónico" required class="form__field" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
        <input type="text" name="direccion" placeholder="Dirección" class="form__field" value="<?= htmlspecialchars($_GET['direccion'] ?? '') ?>">
        <textarea name="notas" placeholder="Notas" class="form__field"><?= htmlspecialchars($_GET['notas'] ?? '') ?></textarea>
        <select name="producto_id" required class="form__field">
            <option value="">Asociar a producto</option>
            <?php foreach ($productos as $p): ?>
                <option value="<?= $p["ID"] ?>"><?= htmlspecialchars($p["nombre"]) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary">Añadir cliente</button>
    </form>

    <?php if (!empty($contactos)): ?>
        <h3>Listado de clientes</h3>
        <table class="tabla">
            <tr><th>Nombre</th><th>Empresa</th><th>Teléfono</th><th>Email</th><th>Dirección</th><th>Notas</th><th>Producto</th></tr>
            <?php foreach ($contactos as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c["nombre"]) ?></td>
                    <td><?= htmlspecialchars($c["empresa"]) ?></td>
                    <td><?= htmlspecialchars($c["telefono"]) ?></td>
                    <td><?= htmlspecialchars($c["email"]) ?></td>
                    <td><?= htmlspecialchars($c["direccion"]) ?></td>
                    <td><?= htmlspecialchars($c["notas"]) ?></td>
                    <td><?= htmlspecialchars($c["producto"]) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No hay contactos registrados.</p>
    <?php endif; ?>
</section>

<?php if (isset($_GET['error'])): ?>
<script>
alert("<?= match ($_GET['error']) {
    'missing' => 'Debes completar el nombre y el correo.',
    'invalid_email' => 'El correo no es válido.',
    'duplicate' => 'Ya existe un contacto con ese correo.',
    'missing_product' => 'Debes seleccionar un producto',
    default => 'Error al guardar el contacto.'
} ?>");
</script>
<?php elseif (isset($_GET['success'])): ?>
<script>alert("Contacto guardado correctamente.");</script>
<?php endif; ?>
</body>
</html>
