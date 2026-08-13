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
    !isset($datos["apellidos"]) ||
    !isset($datos["correo"]) ||
    !isset($datos["rol"]) ||
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
$apellidos = trim($datos["apellidos"]);
$correo = trim($datos["correo"]);
$rol = strtoupper($datos["rol"]);
$estado = strtoupper($datos["estado"]);

$sql = "
    UPDATE USUARIO_SISTEMA
    SET
        NOMBRE = :nombre,
        APELLIDOS = :apellidos,
        CORREO = :correo,
        ROL = :rol,
        ESTADO = :estado
    WHERE ID_USUARIO = :id
";

$sentencia = oci_parse(
    $conexion,
    $sql
);

oci_bind_by_name(
    $sentencia,
    ":nombre",
    $nombre
);

oci_bind_by_name(
    $sentencia,
    ":apellidos",
    $apellidos
);

oci_bind_by_name(
    $sentencia,
    ":correo",
    $correo
);

oci_bind_by_name(
    $sentencia,
    ":rol",
    $rol
);

oci_bind_by_name(
    $sentencia,
    ":estado",
    $estado
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
        "mensaje" => "No se pudo actualizar el usuario.",
        "error" => $error["message"]
    ]);

    exit;
}

echo json_encode([
    "exito" => true,
    "mensaje" => "Usuario actualizado correctamente."
]);

oci_free_statement($sentencia);
oci_close($conexion);