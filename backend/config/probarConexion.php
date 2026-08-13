<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "conexion.php";

echo json_encode([
    "exito" => true,
    "mensaje" => "Conexión exitosa con Oracle Cloud mediante wallet."
]);

oci_close($conexion);