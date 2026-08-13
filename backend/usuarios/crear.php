<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$datos = json_decode(
    file_get_contents("php://input"),
    true
);

if (
    !isset($datos["nombre"]) ||
    !isset($datos["apellidos"]) ||
    !isset($datos["correo"]) ||
    !isset($datos["contrasena"]) ||
    !isset($datos["rol"]) ||
    !isset($datos["estado"])
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "Faltan datos del usuario."
    ]);

    exit;
}

$nombre = trim($datos["nombre"]);
$apellidos = trim($datos["apellidos"]);
$correo = trim($datos["correo"]);
$contrasena = $datos["contrasena"];
$rol = strtoupper($datos["rol"]);
$estado = strtoupper($datos["estado"]);

if (
    $nombre === "" ||
    $apellidos === "" ||
    $correo === "" ||
    $contrasena === ""
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "Todos los campos son obligatorios."
    ]);

    exit;
}

if (
    $rol !== "ADMINISTRADOR" &&
    $rol !== "RECEPCIONISTA"
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "Rol no válido."
    ]);

    exit;
}

if (
    $estado !== "ACTIVO" &&
    $estado !== "INACTIVO"
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "Estado no válido."
    ]);

    exit;
}

$sqlId = "
    SELECT
        NVL(MAX(ID_USUARIO), 0) + 1
        AS NUEVO_ID
    FROM USUARIO_SISTEMA
";

$sentenciaId = oci_parse(
    $conexion,
    $sqlId
);

oci_execute($sentenciaId);

$filaId = oci_fetch_assoc(
    $sentenciaId
);

$nuevoId = $filaId["NUEVO_ID"];

$sql = "
    INSERT INTO USUARIO_SISTEMA (
        ID_USUARIO,
        NOMBRE,
        APELLIDOS,
        CORREO,
        CONTRASENA,
        ROL,
        ESTADO
    )
    VALUES (
        :id,
        :nombre,
        :apellidos,
        :correo,
        :contrasena,
        :rol,
        :estado
    )
";

$sentencia = oci_parse(
    $conexion,
    $sql
);

oci_bind_by_name(
    $sentencia,
    ":id",
    $nuevoId
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
    ":contrasena",
    $contrasena
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

$resultado = oci_execute(
    $sentencia,
    OCI_COMMIT_ON_SUCCESS
);

if (!$resultado) {

    $error = oci_error($sentencia);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo registrar el usuario.",
        "error" => $error["message"]
    ]);

    exit;
}

echo json_encode([
    "exito" => true,
    "mensaje" => "Usuario registrado correctamente.",
    "id" => (int) $nuevoId
]);

oci_free_statement($sentenciaId);
oci_free_statement($sentencia);
oci_close($conexion);