<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$datos = json_decode(
    file_get_contents("php://input"),
    true
);

if (
    !isset($datos["id"]) ||
    !isset($datos["nombre"]) ||
    !isset($datos["tipo"]) ||
    !isset($datos["superficie"]) ||
    !isset($datos["capacidad"]) ||
    !isset($datos["tarifa"]) ||
    !isset($datos["estado"])
) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Faltan datos para actualizar."
    ]);

    exit;
}

$id = $datos["id"];
$nombre = trim($datos["nombre"]);
$tipo = $datos["tipo"];
$superficie = $datos["superficie"];
$capacidad = $datos["capacidad"];
$tarifa = $datos["tarifa"];
$estado = $datos["estado"];

if ($capacidad <= 0 || $tarifa <= 0) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Capacidad y tarifa deben ser mayores a cero."
    ]);

    exit;
}

$sql = "
    UPDATE CANCHA
    SET
        NOMBRE = :nombre,
        TIPO = :tipo,
        SUPERFICIE = :superficie,
        CAPACIDAD = :capacidad,
        TARIFA_HORA = :tarifa,
        ESTADO = :estado
    WHERE ID_CANCHA = :id
";

$sentencia = oci_parse(
    $conexion,
    $sql
);

oci_bind_by_name($sentencia, ":nombre", $nombre);
oci_bind_by_name($sentencia, ":tipo", $tipo);
oci_bind_by_name($sentencia, ":superficie", $superficie);
oci_bind_by_name($sentencia, ":capacidad", $capacidad);
oci_bind_by_name($sentencia, ":tarifa", $tarifa);
oci_bind_by_name($sentencia, ":estado", $estado);
oci_bind_by_name($sentencia, ":id", $id);

$resultado = oci_execute(
    $sentencia,
    OCI_COMMIT_ON_SUCCESS
);

if (!$resultado) {
    $error = oci_error($sentencia);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo actualizar la cancha.",
        "error" => $error["message"]
    ]);

    exit;
}

echo json_encode([
    "exito" => true,
    "mensaje" => "Cancha actualizada correctamente."
]);

oci_free_statement($sentencia);
oci_close($conexion);