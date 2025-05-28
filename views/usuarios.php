<?php
session_start();
if (!isset($_SESSION["usuario"]) || $_SESSION["rol"] !== "admin") {
    header("Location: login.php");
    exit();
}

require_once '../config/conexion.php';
require_once '../models/Usuario.php';

$modelo = new Usuario($conn);
$usuarios = $modelo->listar(); // método que deberías tener en Usuario.php
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Listado de usuarios</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>

<section class="section">
    <h2 class="titulo">Gestión de usuarios</h2>

    <?php if (isset($_GET['mensaje']) && $_GET['mensaje'] === 'actualizado'): ?>
        <div class="mensaje mensaje--exito">✅ Usuario actualizado correctamente.</div>
    <?php endif; ?>

    <table class="tabla">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td><?= htmlspecialchars($usuario['rol']) ?></td>
                <td>
                   <a href='editar_usuario.php?id=<?= $usuario["ID"] ?>' class='btn btn-sm'>Editar</a>
                   <form method="POST" action="../controllers/usuario.php" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">
                        <input type="hidden" name="id" value="<?= $usuario['ID'] ?>">
                        <button type="submit" name="accion" value="eliminar" class="btn btn-sm btn-danger">Eliminar</button>
                    </form>

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>

<?php if (isset($_GET['error'])): ?>
<script>
alert("<?= match ($_GET['error']) {
    'id_vacio' => 'No se ha encontrado ningún ID para eliminar.',
    default => 'Error al eliminar el contacto.'
} ?>");
</script>
<?php elseif (isset($_GET['success'])): ?>
<script>alert("Usuario eliminado correctamente.");</script>
<?php endif; ?>

</body>
</html>
