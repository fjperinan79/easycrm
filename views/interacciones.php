<?php
require_once '../includes/auth.php';
require_login();
require_once '../config/conexion.php';

$res = $conn->query("
    SELECT I.*, C.nombre AS contacto
    FROM interacciones I
    JOIN contactos C ON I.contacto_id = C.ID
    ORDER BY I.fecha DESC
");
$interacciones = $res->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Interacciones</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo">Interacciones registradas</h2>
    <form method="POST" action="../controllers/interacciones.php" class="form">
        <label for="contacto_id">Contacto</label>
        <select id="contacto_id" name="contacto_id" required class="form__field">
            <option value="">Seleccione un contacto</option>
            <?php
            require_once '../config/conexion.php';
            $result = $conn->query("SELECT ID, nombre FROM contactos ORDER BY nombre");
            while ($row = $result->fetch_assoc()):
            ?>
                <option value="<?= $row['ID'] ?>"><?= htmlspecialchars($row['nombre']) ?></option>
            <?php endwhile; ?>
        </select>

        
        <label for="tipo_interaccion">Tipo de interacción</label>
        <select id="tipo_interaccion" name="tipo_interaccion">
            <option value="llamada">Llamada</option>
            <option value="email">Email</option>
            <option value="chat">Chat</option>
        </select>

        <label for="notas">Notas</label>
        <textarea name="notas" class="form__field"></textarea>

        <button type="submit" class="btn">Guardar interacción</button>
    </form>

    <table class="tabla">
        <thead>
            <tr>
                <th>ID</th><th>Fecha</th><th>Contacto</th><th>Tipo</th><th>Notas</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($interacciones as $i): ?>
            <tr>
                <td><?= htmlspecialchars($i["ID"]) ?></td>
                <td><?= htmlspecialchars($i["fecha"]) ?></td>
                <td><?= htmlspecialchars($i["contacto"]) ?></td>
                <td><?= htmlspecialchars($i["tipo_interaccion"]) ?></td>
                <td><?= htmlspecialchars($i["notas"]) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</section>

<script src="../public/js/select2.js"></script>

</body>
</html>
