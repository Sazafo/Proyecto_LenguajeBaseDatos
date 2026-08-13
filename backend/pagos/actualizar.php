<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$d = json_decode(file_get_contents("php://input"), true);

if (!isset(
    $d["id"],
    $d["id_reserva"],
    $d["monto"],
    $d["metodo"],
    $d["estado"]
)) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Faltan datos para actualizar."
    ]);

    exit;
}

$sql = "UPDATE PAGO
        SET ID_RESERVA = :reserva,
            MONTO = :monto,
            METODO_PAGO = :metodo,
            ESTADO = :estado
        WHERE ID_PAGO = :id";

$s = oci_parse($conexion, $sql);

oci_bind_by_name($s, ":reserva", $d["id_reserva"]);
oci_bind_by_name($s, ":monto", $d["monto"]);
oci_bind_by_name($s, ":metodo", $d["metodo"]);
oci_bind_by_name($s, ":estado", $d["estado"]);
oci_bind_by_name($s, ":id", $d["id"]);

if (!oci_execute($s, OCI_COMMIT_ON_SUCCESS)) {

    $e = oci_error($s);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo actualizar el pago.",
        "error" => $e["message"]
    ]);

    exit;
}

echo json_encode([
    "exito" => true,
    "mensaje" => "Pago actualizado correctamente."
]);

oci_free_statement($s);
oci_close($conexion);

?>