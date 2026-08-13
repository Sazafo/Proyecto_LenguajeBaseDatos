<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$sql = "
    SELECT
        ID_USUARIO,
        NOMBRE,
        APELLIDOS,
        CORREO,
        ROL,
        ESTADO
    FROM USUARIO_SISTEMA
    ORDER BY ID_USUARIO
";

$sentencia = oci_parse($conexion, $sql);

if (!$sentencia) {
    $error = oci_error($conexion);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo preparar la consulta.",
        "error" => $error["message"]
    ]);

    exit;
}

if (!oci_execute($sentencia)) {
    $error = oci_error($sentencia);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudieron consultar los usuarios.",
        "error" => $error["message"]
    ]);

    exit;
}

$usuarios = [];

while ($fila = oci_fetch_assoc($sentencia)) {

    $usuarios[] = [
        "id" => (int) $fila["ID_USUARIO"],
        "nombre" => $fila["NOMBRE"],
        "apellidos" => $fila["APELLIDOS"],
        "correo" => $fila["CORREO"],
        "rol" => $fila["ROL"],
        "estado" => $fila["ESTADO"]
    ];
}

echo json_encode([
    "exito" => true,
    "usuarios" => $usuarios
]);

oci_free_statement($sentencia);
oci_close($conexion);