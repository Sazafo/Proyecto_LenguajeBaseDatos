<?php

header("Content-Type: application/json; charset=UTF-8");

session_start();

require_once "../config/conexion.php";

$datos = json_decode(
    file_get_contents("php://input"),
    true
);

if (
    !isset($datos["correo"]) ||
    !isset($datos["contrasena"])
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "Ingrese correo y contraseña."
    ]);

    exit;
}

$correo = trim($datos["correo"]);
$contrasena = $datos["contrasena"];

$sql = "
    SELECT
        ID_USUARIO,
        NOMBRE,
        APELLIDOS,
        CORREO,
        CONTRASENA,
        ROL,
        ESTADO
    FROM USUARIO_SISTEMA
    WHERE CORREO = :correo
";

$sentencia = oci_parse(
    $conexion,
    $sql
);

oci_bind_by_name(
    $sentencia,
    ":correo",
    $correo
);

if (!oci_execute($sentencia)) {

    $error = oci_error($sentencia);

    echo json_encode([
        "exito" => false,
        "mensaje" => "Error al consultar el usuario.",
        "error" => $error["message"]
    ]);

    exit;
}

$usuario = oci_fetch_assoc(
    $sentencia
);

if (!$usuario) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "Correo o contraseña incorrectos."
    ]);

    exit;
}

if (
    $usuario["CONTRASENA"] !==
    $contrasena
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "Correo o contraseña incorrectos."
    ]);

    exit;
}

if (
    $usuario["ESTADO"] !==
    "ACTIVO"
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "El usuario se encuentra inactivo."
    ]);

    exit;
}


/* GUARDAMOS LOS DATOS EN SESIÓN */

$_SESSION["usuario_id"] =
    (int) $usuario["ID_USUARIO"];

$_SESSION["usuario_nombre"] =
    $usuario["NOMBRE"] .
    " " .
    $usuario["APELLIDOS"];

$_SESSION["usuario_correo"] =
    $usuario["CORREO"];

$_SESSION["usuario_rol"] =
    $usuario["ROL"];


echo json_encode([
    "exito" => true,
    "mensaje" => "Inicio de sesión correcto.",
    "rol" => $usuario["ROL"]
]);

oci_free_statement(
    $sentencia
);

oci_close(
    $conexion
);