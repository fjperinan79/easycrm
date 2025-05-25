<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="header">
    <img src="../public/img/logo.png" alt="EasyCRM" class="logo">
    <nav>
        <ul class="nav">
            <?php if (isset($_SESSION["rol"]) && $_SESSION["rol"] === "admin"): ?>
                <li><a href="../views/panel.php">Panel</a></li>
                <li><a href="../views/contactos.php">Contactos</a></li>
                <li><a href="../views/productos.php">Productos</a></li>
                <li><a href="../views/tickets.php">Tickets</a></li>
                <li><a href="../views/reportes.php">Reportes</a></li>
                <li><a href="../views/interacciones.php">Interacciones</a></li>
                <li><a href="../views/contacto.php">Contacto</a></li>
            <?php elseif (isset($_SESSION["rol"]) && $_SESSION["rol"] === "usuario"): ?>
                <li><a href="../views/tickets.php">Tickets</a></li>
                <li><a href="../views/interacciones.php">Interacciones</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <form action="../controllers/logout.php" method="post">
        <button type="submit" class="btn">Cerrar sesión</button>
    </form>
</header>