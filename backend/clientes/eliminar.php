<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "../config/conexion.php";

$d = json_decode(file_get_contents("php://input"), true);
if (!isset($d["id"])) {
    echo json_encode(["exito"=>false,"mensaje"=>"No se recibió el ID del cliente."]);
    exit;
}

$sql = "DELETE FROM CLIENTE WHERE ID_CLIENTE=:id";
$s = oci_parse($conexion, $sql);
oci_bind_by_name($s, ":id", $d["id"]);

if (!oci_execute($s, OCI_COMMIT_ON_SUCCESS)) {
    $e = oci_error($s);
    echo json_encode(["exito"=>false,"mensaje"=>"No se pudo eliminar el cliente. Puede tener reservas asociadas.","error"=>$e["message"]]);
    exit;
}

echo json_encode(["exito"=>true,"mensaje"=>"Cliente eliminado correctamente."]);
oci_free_statement($s);
oci_close($conexion);
?>