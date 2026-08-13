<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$datos = json_decode(
    file_get_contents("php://input"),
    true
);

if (
    !isset($datos["nombre"]) ||
    !isset($datos["tipo"]) ||
    !isset($datos["superficie"]) ||
    !isset($datos["capacidad"]) ||
    !isset($datos["tarifa"]) ||
    !isset($datos["estado"])
) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Faltan datos de la cancha."
    ]);

    exit;
}

$nombre = trim($datos["nombre"]);
$tipo = $datos["tipo"];
$superficie = $datos["superficie"];
$capacidad = $datos["capacidad"];
$tarifa = $datos["tarifa"];
$estado = $datos["estado"];

if ($nombre === "") {
    echo json_encode([
        "exito" => false,
        "mensaje" => "El nombre es obligatorio."
    ]);

    exit;
}

if ($capacidad <= 0) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "La capacidad debe ser mayor a cero."
    ]);

    exit;
}

if ($tarifa <= 0) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "La tarifa debe ser mayor a cero."
    ]);

    exit;
}

$sqlId = "
    SELECT
        CASE
            WHEN MAX(ID_CANCHA) IS NULL THEN 1
            ELSE MAX(ID_CANCHA) + 1
        END AS NUEVO_ID
    FROM CANCHA
";

$sentenciaId = oci_parse(
    $conexion,
    $sqlId
);

if (!oci_execute($sentenciaId)) {
    $error = oci_error($sentenciaId);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo generar el ID.",
        "error" => $error["message"]
    ]);

    exit;
}

$filaId = oci_fetch_assoc($sentenciaId);

$nuevoId = $filaId["NUEVO_ID"];

$sql = "
    INSERT INTO CANCHA (
        ID_CANCHA,
        NOMBRE,
        TIPO,
        SUPERFICIE,
        CAPACIDAD,
        TARIFA_HORA,
        ESTADO
    )
    VALUES (
        :id,
        :nombre,
        :tipo,
        :superficie,
        :capacidad,
        :tarifa,
        :estado
    )
";

$sentencia = oci_parse(
    $conexion,
    $sql
);

oci_bind_by_name($sentencia, ":id", $nuevoId);
oci_bind_by_name($sentencia, ":nombre", $nombre);
oci_bind_by_name($sentencia, ":tipo", $tipo);
oci_bind_by_name($sentencia, ":superficie", $superficie);
oci_bind_by_name($sentencia, ":capacidad", $capacidad);
oci_bind_by_name($sentencia, ":tarifa", $tarifa);
oci_bind_by_name($sentencia, ":estado", $estado);

$resultado = oci_execute(
    $sentencia,
    OCI_COMMIT_ON_SUCCESS
);

if (!$resultado) {
    $error = oci_error($sentencia);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo registrar la cancha.",
        "error" => $error["message"]
    ]);

    exit;
}

echo json_encode([
    "exito" => true,
    "mensaje" => "Cancha registrada correctamente.",
    "id" => (int) $nuevoId
]);

oci_free_statement($sentenciaId);
oci_free_statement($sentencia);
oci_close($conexion);