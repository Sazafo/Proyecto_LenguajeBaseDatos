<?php

$usuarioOracle = "Admin";
$contrasenaOracle = "LalaRemisa22*"; 
$servidorOracle = "localhost/XEPDB1";

$conexion = oci_connect(
    $usuarioOracle,
    $contrasenaOracle,
    $servidorOracle,
    "AL32UTF8"
);

if (!$conexion) {
    $error = oci_error();

    http_response_code(500);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo conectar con Oracle",
        "error" => $error["message"]
    ]);

    exit;
}
?>