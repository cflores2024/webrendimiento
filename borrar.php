<?php
  date_default_timezone_set("America/Argentina/Tucuman");
  
$fecha_inicio = "2025-04-01 00:00:00";
$fecha_fin = "2025-04-08 23:59:59";

$timestamp_inicio = strtotime($fecha_inicio);
$timestamp_fin = strtotime($fecha_fin);

while ($timestamp_inicio <= $timestamp_fin) {
    echo date("H:i:s", $timestamp_inicio) . "\n";
    $timestamp_inicio += 86400; // Incrementa un día (86400 segundos)
}

?>