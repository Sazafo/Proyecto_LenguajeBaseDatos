<?php

header("Content-Type: application/json; charset=UTF-8");

session_start();

if (!isset($_SESSION["usuario_id"])) {

    http_response_code(401);

    echo json_encode([
        "exito" => false,
        "mensaje" => "Debe iniciar sesión."
    ]);

    exit;
}

require_once "../config/conexion.php";


$datos = json_decode(
    file_get_contents("php://input"),
    true
);


if (
    !isset($datos["fecha_inicio"]) ||
    !isset($datos["fecha_fin"])
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "Debe indicar fecha y hora de inicio y fin."
    ]);

    exit;
}


$fechaInicio = str_replace(
    "T",
    " ",
    $datos["fecha_inicio"]
);

$fechaFin = str_replace(
    "T",
    " ",
    $datos["fecha_fin"]
);


if (
    strtotime($fechaFin) <=
    strtotime($fechaInicio)
) {

    echo json_encode([
        "exito" => false,
        "mensaje" => "La fecha final debe ser posterior a la inicial."
    ]);

    exit;
}


/*
    Una cancha está reservada si existe
    una reserva que se cruce con el horario solicitado.

    No tomamos en cuenta reservas CANCELADAS.
*/

$sql = "
    SELECT
        C.ID_CANCHA,
        C.NOMBRE,
        C.TIPO,
        C.SUPERFICIE,
        C.CAPACIDAD,
        C.TARIFA_HORA,
        C.ESTADO,

        CASE

            WHEN C.ESTADO = 'MANTENIMIENTO'
                THEN 'MANTENIMIENTO'

            WHEN C.ESTADO = 'INACTIVA'
                THEN 'INACTIVA'

            WHEN EXISTS (

                SELECT 1

                FROM RESERVA R

                WHERE
                    R.ID_CANCHA = C.ID_CANCHA

                    AND R.ESTADO <> 'CANCELADA'

                    AND R.FECHA_INICIO <
                        TO_DATE(
                            :fecha_fin,
                            'YYYY-MM-DD HH24:MI'
                        )

                    AND R.FECHA_FIN >
                        TO_DATE(
                            :fecha_inicio,
                            'YYYY-MM-DD HH24:MI'
                        )
            )

                THEN 'RESERVADA'

            ELSE 'DISPONIBLE'

        END AS DISPONIBILIDAD

    FROM CANCHA C

    ORDER BY C.ID_CANCHA
";


$sentencia = oci_parse(
    $conexion,
    $sql
);


if (!$sentencia) {

    $error = oci_error(
        $conexion
    );

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo preparar la consulta.",
        "error" => $error["message"]
    ]);

    exit;
}


oci_bind_by_name(
    $sentencia,
    ":fecha_inicio",
    $fechaInicio
);

oci_bind_by_name(
    $sentencia,
    ":fecha_fin",
    $fechaFin
);


if (!oci_execute($sentencia)) {

    $error = oci_error(
        $sentencia
    );

    echo json_encode([
        "exito" => false,
        "mensaje" => "No se pudo consultar la disponibilidad.",
        "error" => $error["message"]
    ]);

    exit;
}


$canchas = [];


while (
    $fila =
        oci_fetch_assoc(
            $sentencia
        )
) {

    $canchas[] = [

        "id" =>
            (int)
            $fila["ID_CANCHA"],

        "nombre" =>
            $fila["NOMBRE"],

        "tipo" =>
            $fila["TIPO"],

        "superficie" =>
            $fila["SUPERFICIE"],

        "capacidad" =>
            (int)
            $fila["CAPACIDAD"],

        "tarifa" =>
            (float)
            $fila["TARIFA_HORA"],

        "estado" =>
            $fila["ESTADO"],

        "disponibilidad" =>
            $fila["DISPONIBILIDAD"]
    ];
}


echo json_encode([
    "exito" => true,
    "canchas" => $canchas
]);


oci_free_statement(
    $sentencia
);

oci_close(
    $conexion
);