<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../includes/auth.php';
require_login();
require_once '../config/conexion.php';
require_once '../models/Ticket.php';

$modelo = new Ticket($conn);
$tickets = $modelo->listar();

if (isset($_GET['buscar_id']) && is_numeric($_GET['buscar_id'])) {
    $tickets = array_filter($tickets, fn($t) => $t['ID'] == $_GET['buscar_id']);
}

$contactos = $conn->query("SELECT ID, nombre FROM contactos")->fetch_all(MYSQLI_ASSOC);
$usuarios = $conn->query("SELECT ID, nombre FROM usuarios")->fetch_all(MYSQLI_ASSOC);
$edit_ticket = isset($_GET["edit"]) ? $modelo->obtenerPorID($_GET["edit"]) : null;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Tickets</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo"><?= $edit_ticket ? 'Editar ticket' : 'Crear nuevo ticket' ?></h2>
    <form method="post" action="../controllers/tickets.php" class="form">
        <?php if ($edit_ticket): ?>
            <input type="hidden" name="id" value="<?= $edit_ticket["ID"] ?>">
        <?php endif; ?>
        <input name="titulo" placeholder="Título" required class="form__field" value="<?= $edit_ticket["titulo"] ?? '' ?>">
        <textarea name="descripcion" placeholder="Descripción" required class="form__field"><?= $edit_ticket["descripcion"] ?? '' ?></textarea>
        <select id="contacto_id" name="contacto_id" required class="form__field">
            <option value="">Seleccionar contacto</option>
            <?php foreach ($contactos as $c): ?>
                <option value="<?= $c["ID"] ?>" <?= (isset($edit_ticket) && $edit_ticket["contacto_id"] == $c["ID"]) ? "selected" : "" ?>>
                    <?= htmlspecialchars($c["nombre"]) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="usuario_asignado" class="form__field">
            <option value="">Sin asignar</option>
            <?php foreach ($usuarios as $u): ?>
                <option value="<?= $u["ID"] ?>" <?= (isset($edit_ticket) && $edit_ticket["usuario_asignado"] == $u["ID"]) ? "selected" : "" ?>>
                    <?= htmlspecialchars($u["nombre"]) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="estado" required class="form__field">
            <option value="">Estado</option>
            <?php foreach (["abierto", "en progreso", "cerrado"] as $estado): ?>
                <option value="<?= $estado ?>" <?= (isset($edit_ticket) && $edit_ticket["estado"] == $estado) ? "selected" : "" ?>>
                    <?= ucfirst($estado) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <select name="prioridad" required class="form__field">
            <option value="">Prioridad</option>
            <?php foreach (["baja", "media", "alta"] as $pri): ?>
                <option value="<?= $pri ?>" <?= (isset($edit_ticket) && $edit_ticket["prioridad"] == $pri) ? "selected" : "" ?>>
                    <?= ucfirst($pri) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn"><?= $edit_ticket ? "Actualizar" : "Crear" ?> ticket</button>
    </form>

    <?php if (!empty($tickets)): ?>
        <form method="get" class="form" style="max-width:300px;">
            <input type="number" name="buscar_id" placeholder="Buscar ticket por ID" class="form__field">
            <button type="submit" class="btn">Buscar</button>
        </form>
        <h3>Listado de tickets</h3>
        <table class="tabla">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Estado</th>
                    <th>Prioridad</th>
                    <th>Contacto</th>
                    <th>Asignado</th>
                    <th>Editar</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tickets as $t): ?>
                <tr>
                    <td><?= htmlspecialchars($t["ID"]) ?></td>
                    <td><?= htmlspecialchars($t["titulo"]) ?></td>
                    <td><?= htmlspecialchars($t["estado"]) ?></td>
                    <td><?= htmlspecialchars($t["prioridad"]) ?></td>
                    <td><?= htmlspecialchars($t["contacto"]) ?></td>
                    <td><?= htmlspecialchars($t["asignado"] ?? '-') ?></td>
                    <td><a href="?edit=<?= $t["ID"] ?>">✏️</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<script src="../public/js/select2.js"></script>

</body>
</html>
