<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$datos = json_decode(
    file_get_contents("php://input"),
    true
);

if (!isset($datos["id"])) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "No se recibió el ID de la cancha."
    ]);

    exit;
}

$id = $datos["id"];

$sql = "
    DELETE FROM CANCHA
    WHERE ID_CANCHA = :id
";

$sentencia = oci_parse(
    $conexion,
    $sql
);

oci_bind_by_name(
    $sentencia,
    ":id",
    $id
);

$resultado = oci_execute(
    $sentencia,
    OCI_COMMIT_ON_SUCCESS
);

if (!$resultado) {
    $error = oci_error($sentencia);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo eliminar la cancha.",
        "error" => $error["message"]
    ]);

    exit;
}

echo json_encode([
    "exito" => true,
    "mensaje" => "Cancha eliminada correctamente."
]);

oci_free_statement($sentencia);
oci_close($conexion);