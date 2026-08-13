<?php
header("Content-Type: application/json; charset=UTF-8");
require_once "../config/conexion.php";

$sql = "SELECT R.ID_RESERVA, R.ID_CLIENTE, R.ID_CANCHA,
               TO_CHAR(R.FECHA_INICIO,'YYYY-MM-DD HH24:MI') FECHA_INICIO,
               TO_CHAR(R.FECHA_FIN,'YYYY-MM-DD HH24:MI') FECHA_FIN,
               R.ESTADO,
               C.NOMBRE || ' ' || C.APELLIDOS CLIENTE,
               CA.NOMBRE CANCHA
        FROM RESERVA R
        JOIN CLIENTE C ON C.ID_CLIENTE = R.ID_CLIENTE
        JOIN CANCHA CA ON CA.ID_CANCHA = R.ID_CANCHA
        ORDER BY R.ID_RESERVA";
$s=oci_parse($conexion,$sql);
if(!oci_execute($s)){
    $e=oci_error($s);
    echo json_encode(["exito"=>false,"mensaje"=>"No se pudieron consultar las reservas.","error"=>$e["message"]]); exit;
}
$reservas=[];
while($f=oci_fetch_assoc($s)){
    $reservas[]=[
        "id"=>(int)$f["ID_RESERVA"],
        "id_cliente"=>(int)$f["ID_CLIENTE"],
        "id_cancha"=>(int)$f["ID_CANCHA"],
        "fecha_inicio"=>$f["FECHA_INICIO"],
        "fecha_fin"=>$f["FECHA_FIN"],
        "estado"=>$f["ESTADO"],
        "cliente"=>$f["CLIENTE"],
        "cancha"=>$f["CANCHA"]
    ];
}
echo json_encode(["exito"=>true,"reservas"=>$reservas]);
oci_free_statement($s); oci_close($conexion);
?>