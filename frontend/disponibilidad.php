<?php

session_start();

if (!isset($_SESSION["usuario_id"])) {

    header(
        "Location: login.php"
    );

    exit;
}


$nombreUsuario =
    $_SESSION["usuario_nombre"];

$rolUsuario =
    $_SESSION["usuario_rol"];

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Disponibilidad | FieldBook Pro
    </title>

    <link
        rel="stylesheet"
        href="/Proyecto_LenguajeBaseDatos/frontend/css/estilos.css?v=8"
    >

</head>

<body>


<header class="encabezado">

    <div class="contenedor encabezado-flex">

        <div>

            <h1>
                FieldBook Pro
            </h1>

            <p>
                Sistema de reservas de canchas de fútbol
            </p>

        </div>


        <div class="usuario-sesion">

            <div class="datos-usuario">

                <strong>

                    <?php

                    echo htmlspecialchars(
                        $nombreUsuario
                    );

                    ?>

                </strong>


                <span>

                    <?php

                    echo htmlspecialchars(
                        $rolUsuario
                    );

                    ?>

                </span>

            </div>


            <a
                href="index.php"
                class="enlace-inicio"
            >
                Inicio
            </a>

        </div>

    </div>

</header>


<main class="contenedor">


    <!-- CABECERA -->

    <section class="cabecera-modulo">

        <p class="ruta-modulo">
            Panel principal / Disponibilidad
        </p>

        <h2>
            Disponibilidad de canchas
        </h2>

        <p>
            Consulte qué canchas se encuentran
            disponibles para un horario determinado.
        </p>

    </section>


    <!-- FORMULARIO -->

    <section class="panel">


        <div class="titulo-panel">

            <div>

                <h2>
                    Consultar horario
                </h2>

                <p>
                    Seleccione la fecha y hora
                    que desea consultar.
                </p>

            </div>

        </div>


        <form id="formDisponibilidad">


            <div class="form-grid">


                <div class="campo">

                    <label for="fechaInicioDisponibilidad">
                        Fecha y hora de inicio
                    </label>

                    <input
                        type="datetime-local"
                        id="fechaInicioDisponibilidad"
                        required
                    >

                </div>


                <div class="campo">

                    <label for="fechaFinDisponibilidad">
                        Fecha y hora final
                    </label>

                    <input
                        type="datetime-local"
                        id="fechaFinDisponibilidad"
                        required
                    >

                </div>


            </div>


            <div class="acciones-formulario">

                <button
                    type="submit"
                >
                    Consultar disponibilidad
                </button>

                <button
                    type="button"
                    id="btnLimpiarDisponibilidad"
                    class="boton-secundario"
                >
                    Limpiar
                </button>

            </div>


        </form>


        <p id="mensajeDisponibilidad"></p>


    </section>


    <!-- RESULTADOS -->

    <section
        class="panel"
        id="panelResultadosDisponibilidad"
    >


        <div class="titulo-panel">

            <div>

                <h2>
                    Resultado
                </h2>

                <p>
                    Estado de las canchas
                    para el horario seleccionado.
                </p>

            </div>

        </div>


        <div
            id="listaDisponibilidad"
            class="grid-disponibilidad"
        >

            <p class="texto-informativo">
                Seleccione un horario para
                consultar las canchas.
            </p>

        </div>


    </section>


</main>


<script src="js/disponibilidad.js?v=2"></script>


</body>

</html>