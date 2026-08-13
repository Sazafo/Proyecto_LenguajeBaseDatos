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


/* ==============================
   RESERVAS DE HOY
================================= */

$sqlReservas = "
    SELECT COUNT(*) AS TOTAL
    FROM RESERVA
    WHERE TRUNC(FECHA_INICIO) = TRUNC(SYSDATE)
      AND ESTADO <> 'CANCELADA'
";

$sentenciaReservas =
    oci_parse(
        $conexion,
        $sqlReservas
    );

oci_execute(
    $sentenciaReservas
);

$filaReservas =
    oci_fetch_assoc(
        $sentenciaReservas
    );

$reservasHoy =
    (int)
    $filaReservas["TOTAL"];


/* ==============================
   PAGOS PENDIENTES
================================= */

$sqlPagos = "
    SELECT COUNT(*) AS TOTAL
    FROM PAGO
    WHERE ESTADO = 'PENDIENTE'
";

$sentenciaPagos =
    oci_parse(
        $conexion,
        $sqlPagos
    );

oci_execute(
    $sentenciaPagos
);

$filaPagos =
    oci_fetch_assoc(
        $sentenciaPagos
    );

$pagosPendientes =
    (int)
    $filaPagos["TOTAL"];


/* ==============================
   CANCHAS DISPONIBLES AHORA
================================= */

$sqlCanchas = "
    SELECT COUNT(*) AS TOTAL

    FROM CANCHA C

    WHERE C.ESTADO = 'ACTIVA'

      AND NOT EXISTS (

            SELECT 1

            FROM RESERVA R

            WHERE
                R.ID_CANCHA =
                    C.ID_CANCHA

                AND R.ESTADO
                    <> 'CANCELADA'

                AND SYSDATE >=
                    R.FECHA_INICIO

                AND SYSDATE <
                    R.FECHA_FIN
      )
";

$sentenciaCanchas =
    oci_parse(
        $conexion,
        $sqlCanchas
    );

oci_execute(
    $sentenciaCanchas
);

$filaCanchas =
    oci_fetch_assoc(
        $sentenciaCanchas
    );

$canchasDisponibles =
    (int)
    $filaCanchas["TOTAL"];


/* ==============================
   RESPUESTA
================================= */

echo json_encode([
    "exito" => true,

    "resumen" => [

        "reservas_hoy" =>
            $reservasHoy,

        "pagos_pendientes" =>
            $pagosPendientes,

        "canchas_disponibles" =>
            $canchasDisponibles
    ]
]);


oci_free_statement(
    $sentenciaReservas
);

oci_free_statement(
    $sentenciaPagos
);

oci_free_statement(
    $sentenciaCanchas
);

oci_close(
    $conexion
);