<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "../config/conexion.php";

$d = json_decode(file_get_contents("php://input"), true);
$campos = ["cedula","nombre","apellidos","correo","telefono"];
foreach ($campos as $c) {
    if (!isset($d[$c]) || trim((string)$d[$c]) === "") {
        echo json_encode(["exito"=>false,"mensaje"=>"Faltan datos del cliente."]);
        exit;
    }
}

$sqlId = "SELECT NVL(MAX(ID_CLIENTE),0)+1 AS NUEVO_ID FROM CLIENTE";
$sId = oci_parse($conexion, $sqlId);
oci_execute($sId);
$f = oci_fetch_assoc($sId);
$id = $f["NUEVO_ID"];

$sql = "INSERT INTO CLIENTE
        (ID_CLIENTE, CEDULA, NOMBRE, APELLIDOS, CORREO, TELEFONO)
        VALUES (:id,:cedula,:nombre,:apellidos,:correo,:telefono)";
$s = oci_parse($conexion, $sql);

oci_bind_by_name($s, ":id", $id);
oci_bind_by_name($s, ":cedula", $d["cedula"]);
oci_bind_by_name($s, ":nombre", $d["nombre"]);
oci_bind_by_name($s, ":apellidos", $d["apellidos"]);
oci_bind_by_name($s, ":correo", $d["correo"]);
oci_bind_by_name($s, ":telefono", $d["telefono"]);

if (!oci_execute($s, OCI_COMMIT_ON_SUCCESS)) {
    $e = oci_error($s);
    echo json_encode(["exito"=>false,"mensaje"=>"No se pudo registrar el cliente.","error"=>$e["message"]]);
    exit;
}

echo json_encode(["exito"=>true,"mensaje"=>"Cliente registrado correctamente.","id"=>(int)$id]);
oci_free_statement($sId);
oci_free_statement($s);
oci_close($conexion);
?>