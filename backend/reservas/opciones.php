<?php

header("Content-Type: application/json; charset=UTF-8");

require_once "../config/conexion.php";

// Obtener clientes
$clientes = [];

$sqlClientes = "SELECT 
                    ID_CLIENTE,
                    NOMBRE,
                    APELLIDOS
                FROM CLIENTE
                ORDER BY NOMBRE, APELLIDOS";

$s1 = oci_parse($conexion, $sqlClientes);
oci_execute($s1);

while ($f = oci_fetch_assoc($s1)) {

    $clientes[] = [
        "id" => (int) $f["ID_CLIENTE"],
        "nombre" => $f["NOMBRE"] . " " . $f["APELLIDOS"]
    ];
}

// Obtener canchas
$canchas = [];

$sqlCanchas = "SELECT 
                   ID_CANCHA,
                   NOMBRE,
                   ESTADO
               FROM CANCHA
               ORDER BY NOMBRE";

$s2 = oci_parse($conexion, $sqlCanchas);
oci_execute($s2);

while ($f = oci_fetch_assoc($s2)) {

    $canchas[] = [
        "id" => (int) $f["ID_CANCHA"],
        "nombre" => $f["NOMBRE"],
        "estado" => $f["ESTADO"]
    ];
}

// Respuesta
echo json_encode([
    "exito" => true,
    "clientes" => $clientes,
    "canchas" => $canchas
]);

oci_free_statement($s1);
oci_free_statement($s2);
oci_close($conexion);

?>