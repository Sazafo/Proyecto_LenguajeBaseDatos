<?php

header("Content-Type: application/json; charset=UTF-8");

putenv("TNS_ADMIN=C:\\OracleWallet");

$usuarioOracle = "TU_USUARIO";
$contrasenaOracle = "TU_CONTRASENA";
$servicioOracle = "dbadminoracle_low";

$conexion = oci_connect(
    $usuarioOracle,
    $contrasenaOracle,
    $servicioOracle,
    "AL32UTF8"
);

if (!$conexion) {

    $error = oci_error();

    http_response_code(500);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo conectar con Oracle.",
        "error" => $error["message"]
    ]);

    exit;
}