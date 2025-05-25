<?php
session_start();

if (empty($_SESSION["reportes"])) {
    header("Location: ../views/reportes.php");
    exit();
}

$datos = $_SESSION["reportes"];

// Forzar descarga con nombre de archivo
header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=reporte.csv");
header("Pragma: no-cache");
header("Expires: 0");

// Abrir salida estándar
$output = fopen("php://output", "w");

// Escribir BOM UTF-8 para compatibilidad con Excel
echo "\xEF\xBB\xBF";

// Escribir encabezados
fputcsv($output, array_keys($datos[0]));

// Escribir filas
foreach ($datos as $fila) {
    // Forzar conversión a UTF-8 por seguridad (por si llega de otra fuente)
    $fila_utf8 = array_map(fn($val) => mb_convert_encoding($val, 'UTF-8', 'UTF-8'), $fila);
    fputcsv($output, $fila_utf8);
}

fclose($output);
exit();
