<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit();
}

require_once '../config/conexion.php';

// Consultas con nombres de tabla corregidos (en minúsculas)
$totalContactos = $conn->query("SELECT COUNT(*) FROM contactos")->fetch_row()[0];
$totalProductos = $conn->query("SELECT COUNT(*) FROM productos")->fetch_row()[0];
$totalTickets = $conn->query("SELECT COUNT(*) FROM tickets")->fetch_row()[0];
$ticketsAbiertos = $conn->query("SELECT COUNT(*) FROM tickets WHERE estado='abierto'")->fetch_row()[0];
$totalInteracciones = $conn->query("SELECT COUNT(*) FROM interacciones")->fetch_row()[0];
?>

<!DOCTYPE html>
<html lang="es">
    <title>Panel de control</title>
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
        .card h2 {
            font-size: 2rem;
            margin: 0.5rem 0;
        }
        .card p {
            margin: 0;
            color: #666;
        }
    </style>
</head>
<body>
<?php include '../includes/header.php'; ?>
<section class="section">
    <h2 class="titulo">Bienvenido, <?= htmlspecialchars($_SESSION["usuario"]) ?></h2>
    <div class="dashboard">
        <div class="card">
            <h2><?= $totalContactos ?></h2>
            <p>Contactos</p>
        </div>
        <div class="card">
            <h2><?= $totalProductos ?></h2>
            <p>Productos</p>
        </div>
        <div class="card">
            <h2><?= $totalTickets ?></h2>
            <p>Tickets totales</p>
        </div>
        <div class="card">
            <h2><?= $ticketsAbiertos ?></h2>
            <p>Tickets abiertos</p>
        </div>
        <div class="card">
            <h2><?= $totalInteracciones ?></h2>
            <p>Interacciones</p>
        </div>
    </div>
</section>
</body>
</html>
