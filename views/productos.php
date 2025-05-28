<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}
require_once '../config/conexion.php';
require_once '../models/Producto.php';
$modelo = new Producto($conn);
$productos = $modelo->listar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Productos</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo">Gestión de productos</h2>
    <form method="post" action="../controllers/productos.php" class="form">
        <input name="nombre" placeholder="Nombre" required class="form__field">
        <input name="categoria" placeholder="Categoría" required class="form__field">
        <button type="submit" class="btn">Añadir producto</button>
    </form>

    <?php if (!empty($productos)): ?>
        <h3>Listado de productos</h3>
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Fecha alta</th>
                    <th>Fecha baja</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($productos as $p): ?>
                <tr>
                    <td><?= htmlspecialchars($p["ID"] ?? $p["id"] ?? '') ?></td>
                    <td><?= htmlspecialchars($p["nombre"]) ?></td>
                    <td><?= htmlspecialchars($p["tipo_producto"] ?? '') ?></td>
                    <td><?= htmlspecialchars($p["fecha_alta"] ?? '') ?></td>
                    <td><?= htmlspecialchars($p["fecha_baja"] ?? '') ?></td>
                    <td>
                        <form method="post" action="../controllers/productos.php" style="display:inline;">
                            <input type="hidden" name="baja_id" value="<?= $p["ID"] ?? $p["id"] ?>">
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Dar de baja este producto?')">Dar de baja</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay productos registrados.</p>
    <?php endif; ?>
</section>

<?php if (isset($_GET['error'])): ?>
<script>
alert("<?= $_GET['error'] == 'missing' ? 'Debes completar los campos obligatorios.' : 'Error al guardar el producto.' ?>");
</script>
<?php elseif (isset($_GET['success'])): ?>
<script>alert("Producto registrado correctamente.");</script>
<?php elseif (isset($_GET['baja'])): ?>
<script>alert("Producto dado de baja correctamente.");</script>
<?php endif; ?>
</body>
</html>
