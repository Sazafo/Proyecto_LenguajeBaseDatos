<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$sql = "
    SELECT
        P.ID_PAGO,
        P.ID_RESERVA,
        P.MONTO,
        P.METODO_PAGO,
        TO_CHAR(P.FECHA_PAGO, 'YYYY-MM-DD') AS FECHA_PAGO,
        P.ESTADO
    FROM PAGO P
    ORDER BY P.ID_PAGO
";

$s = oci_parse($conexion, $sql);

if (!oci_execute($s)) {
    $e = oci_error($s);

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudieron consultar los pagos.",
        "error" => $e["message"]
    ]);

    exit;
}

$pagos = [];

while ($f = oci_fetch_assoc($s)) {
    $pagos[] = [
        "id" => (int) $f["ID_PAGO"],
        "id_reserva" => (int) $f["ID_RESERVA"],
        "monto" => (float) $f["MONTO"],
        "metodo" => $f["METODO_PAGO"],
        "fecha" => $f["FECHA_PAGO"],
        "estado" => $f["ESTADO"]
    ];
}

echo json_encode([
    "exito" => true,
    "pagos" => $pagos
]);

oci_free_statement($s);
oci_close($conexion);

?>