<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "../config/conexion.php";

$d = json_decode(file_get_contents("php://input"), true);
$campos = ["id","cedula","nombre","apellidos","correo","telefono"];
foreach ($campos as $c) {
    if (!isset($d[$c])) {
        echo json_encode(["exito"=>false,"mensaje"=>"Faltan datos para actualizar."]);
        exit;
    }
}

$sql = "UPDATE CLIENTE SET CEDULA=:cedula, NOMBRE=:nombre, APELLIDOS=:apellidos,
        CORREO=:correo, TELEFONO=:telefono WHERE ID_CLIENTE=:id";
$s = oci_parse($conexion, $sql);

oci_bind_by_name($s, ":cedula", $d["cedula"]);
oci_bind_by_name($s, ":nombre", $d["nombre"]);
oci_bind_by_name($s, ":apellidos", $d["apellidos"]);
oci_bind_by_name($s, ":correo", $d["correo"]);
oci_bind_by_name($s, ":telefono", $d["telefono"]);
oci_bind_by_name($s, ":id", $d["id"]);

if (!oci_execute($s, OCI_COMMIT_ON_SUCCESS)) {
    $e = oci_error($s);
    echo json_encode(["exito"=>false,"mensaje"=>"No se pudo actualizar el cliente.","error"=>$e["message"]]);
    exit;
}

echo json_encode(["exito"=>true,"mensaje"=>"Cliente actualizado correctamente."]);
oci_free_statement($s);
oci_close($conexion);
?>