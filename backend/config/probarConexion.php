<?php

header("Content-Type: application/json; charset=UTF-8");

require_once __DIR__ . "/conexion.php";

echo json_encode([
    "exito" => true,
    "mensaje" => "Conexión exitosa con Oracle"
]);

if (isset($conexion)) {
    oci_close($conexion);
}