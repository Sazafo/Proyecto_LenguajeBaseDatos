<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

$reservas = [];

$sql = "SELECT 
            R.ID_RESERVA,
            C.NOMBRE || ' ' || C.APELLIDOS AS CLIENTE,
            CA.NOMBRE AS CANCHA
        FROM RESERVA R
        JOIN CLIENTE C 
            ON C.ID_CLIENTE = R.ID_CLIENTE
        JOIN CANCHA CA 
            ON CA.ID_CANCHA = R.ID_CANCHA
        ORDER BY R.ID_RESERVA";

$s = oci_parse($conexion, $sql);
oci_execute($s);

while ($f = oci_fetch_assoc($s)) {

    $reservas[] = [
        "id" => (int) $f["ID_RESERVA"],
        "descripcion" => "Reserva #" . $f["ID_RESERVA"] . 
                         " - " . $f["CLIENTE"] . 
                         " - " . $f["CANCHA"]
    ];
}

echo json_encode([
    "exito" => true,
    "reservas" => $reservas
]);

oci_free_statement($s);
oci_close($conexion);

?>