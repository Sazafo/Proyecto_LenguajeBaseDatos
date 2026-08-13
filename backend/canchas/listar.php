<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$sql = "
    SELECT
        ID_CANCHA,
        NOMBRE,
        TIPO,
        SUPERFICIE,
        CAPACIDAD,
        TARIFA_HORA,
        ESTADO
    FROM CANCHA
    ORDER BY ID_CANCHA
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
        "mensaje" => "No se pudieron consultar las canchas.",
        "error" => $error["message"]
    ]);

    exit;
}

$canchas = [];

while ($fila = oci_fetch_assoc($sentencia)) {

    $canchas[] = [
        "id" => (int) $fila["ID_CANCHA"],
        "nombre" => $fila["NOMBRE"],
        "tipo" => $fila["TIPO"],
        "superficie" => $fila["SUPERFICIE"],
        "capacidad" => (int) $fila["CAPACIDAD"],
        "tarifa" => (float) $fila["TARIFA_HORA"],
        "estado" => $fila["ESTADO"]
    ];
}

echo json_encode([
    "exito" => true,
    "canchas" => $canchas
]);

oci_free_statement($sentencia);
oci_close($conexion);