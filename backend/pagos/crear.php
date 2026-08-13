<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$d = json_decode(file_get_contents("php://input"), true);

if (!isset($d["id_reserva"], $d["monto"], $d["metodo"], $d["estado"])) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "Faltan datos del pago."
    ]);
    exit;
}

if ((float) $d["monto"] <= 0) {
    echo json_encode([
        "exito" => false,
        "mensaje" => "El monto debe ser mayor a cero."
    ]);
    exit;
}

// Obtener el siguiente ID de pago
$sqlId = "SELECT NVL(MAX(ID_PAGO), 0) + 1 AS NUEVO_ID
          FROM PAGO";

$sId = oci_parse($conexion, $sqlId);
oci_execute($sId);

$f = oci_fetch_assoc($sId);
$id = $f["NUEVO_ID"];

// Insertar el pago
$sql = "INSERT INTO PAGO (
            ID_PAGO,
            ID_RESERVA,
            MONTO,
            METODO_PAGO,
            FECHA_PAGO,
            ESTADO
        )
        VALUES (
            :id,
            :reserva,
            :monto,
            :metodo,
            SYSDATE,
            :estado
        )";

$s = oci_parse($conexion, $sql);

oci_bind_by_name($s, ":id", $id);
oci_bind_by_name($s, ":reserva", $d["id_reserva"]);
oci_bind_by_name($s, ":monto", $d["monto"]);
oci_bind_by_name($s, ":metodo", $d["metodo"]);
oci_bind_by_name($s, ":estado", $d["estado"]);

if (!oci_execute($s, OCI_COMMIT_ON_SUCCESS)) {

    $e = oci_error($s);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo registrar el pago.",
        "error" => $e["message"]
    ]);

    exit;
}

echo json_encode([
    "exito" => true,
    "mensaje" => "Pago registrado correctamente.",
    "id" => (int) $id
]);

oci_free_statement($sId);
oci_free_statement($s);
oci_close($conexion);

?>