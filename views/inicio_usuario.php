<?php
require_once '../includes/auth.php';
require_user();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Inicio Usuario</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .card {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            text-align: center;
            transition: 0.3s ease;
        }
        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .card p {
            margin: 0;
            color: #333;
            font-weight: bold;
        }
        .card a {
            text-decoration: none;
            display: block;
            margin-top: 1rem;
            font-weight: bold;
            color: #007bff;
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo">Bienvenido, <?= htmlspecialchars($_SESSION["usuario"]) ?></h2>
    <div class="dashboard">
        <div class="card">
            <p>Gestionar tickets</p>
            <a href="tickets.php">Ir a tickets</a>
        </div>
        <div class="card">
            <p>Registrar interacción</p>
            <a href="interacciones.php">Ir a interacciones</a>
        </div>
    </div>
</section>
</body>
</html>
