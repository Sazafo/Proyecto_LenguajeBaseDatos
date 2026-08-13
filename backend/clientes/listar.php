<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "../config/conexion.php";

$sql = "SELECT ID_CLIENTE, CEDULA, NOMBRE, APELLIDOS, CORREO, TELEFONO
        FROM CLIENTE ORDER BY ID_CLIENTE";
$s = oci_parse($conexion, $sql);

if (!oci_execute($s)) {
    $e = oci_error($s);
    echo json_encode(["exito"=>false,"mensaje"=>"No se pudieron consultar los clientes.","error"=>$e["message"]]);
    exit;
}

$clientes = [];
while ($f = oci_fetch_assoc($s)) {
    $clientes[] = [
        "id" => (int)$f["ID_CLIENTE"],
        "cedula" => $f["CEDULA"],
        "nombre" => $f["NOMBRE"],
        "apellidos" => $f["APELLIDOS"],
        "correo" => $f["CORREO"],
        "telefono" => $f["TELEFONO"]
    ];
}

echo json_encode(["exito"=>true,"clientes"=>$clientes]);
oci_free_statement($s);
oci_close($conexion);
?>