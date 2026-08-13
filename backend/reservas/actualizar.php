<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$d = json_decode(file_get_contents("php://input"), true);

// Validar datos requeridos
if (!isset(
    $d["id"],
    $d["id_cliente"],
    $d["id_cancha"],
    $d["fecha_inicio"],
    $d["fecha_fin"],
    $d["estado"]
)) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Faltan datos para actualizar."
    ]);

    exit;
}

// Validar que la fecha final sea posterior a la inicial
if (strtotime($d["fecha_fin"]) <= strtotime($d["fecha_inicio"])) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "La fecha final debe ser posterior a la inicial."
    ]);

    exit;
}

// Convertir formato de fecha recibido
$fi = str_replace("T", " ", $d["fecha_inicio"]);
$ff = str_replace("T", " ", $d["fecha_fin"]);

// Actualizar la reserva
$sql = "UPDATE RESERVA
        SET ID_CLIENTE = :cliente,
            ID_CANCHA = :cancha,
            FECHA_INICIO = TO_DATE(:fi, 'YYYY-MM-DD HH24:MI'),
            FECHA_FIN = TO_DATE(:ff, 'YYYY-MM-DD HH24:MI'),
            ESTADO = :estado
        WHERE ID_RESERVA = :id";

$s = oci_parse($conexion, $sql);

oci_bind_by_name($s, ":cliente", $d["id_cliente"]);
oci_bind_by_name($s, ":cancha", $d["id_cancha"]);
oci_bind_by_name($s, ":fi", $fi);
oci_bind_by_name($s, ":ff", $ff);
oci_bind_by_name($s, ":estado", $d["estado"]);
oci_bind_by_name($s, ":id", $d["id"]);

// Ejecutar actualización
if (!oci_execute($s, OCI_COMMIT_ON_SUCCESS)) {

    $e = oci_error($s);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo actualizar la reserva.",
        "error" => $e["message"]
    ]);

    exit;
}

// Respuesta exitosa
echo json_encode([
    "exito" => true,
    "mensaje" => "Reserva actualizada correctamente."
]);

oci_free_statement($s);
oci_close($conexion);

?>