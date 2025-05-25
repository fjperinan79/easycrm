<?php
require_once '../includes/auth.php';
require_admin();
$reportes = $_SESSION["reportes"] ?? [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reportes</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo">Generar reporte</h2>
    <form method="post" action="../controllers/reportes.php" class="form">
        <select name="parametro" required class="form__field">
            <option value="">Elige una opción</option>
            <option value="clientes">Clientes</option>
            <option value="tickets">Tickets</option>
            <option value="interacciones">Interacciones</option>
            <option value="productos">Productos</option>
            <option value="mensajes">Mensajes</option>
        </select>
        <button type="submit" class="btn">Ver datos</button>
    </form>

    <?php if (!empty($reportes)): ?>
        
        <form method="post" action="../controllers/exportar_csv.php">
            <button type="submit" class="btn">Exportar a CSV</button>
        </form>

        <h3>Resultado</h3>
        <table class="tabla">
            <thead>
                <tr>
                <?php foreach (array_keys($reportes[0]) as $col): ?>
                    <th><?= htmlspecialchars($col) ?></th>
                <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($reportes as $fila): ?>
                <tr>
                <?php foreach ($fila as $valor): ?>
                    <td><?= htmlspecialchars($valor) ?></td>
                <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
        <p>No se encontraron datos para mostrar.</p>
    <?php endif; ?>
</section>
</body>
</html>
