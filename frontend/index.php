<?php

session_start();

/* =====================================================
   VALIDAR SESIÓN
===================================================== */

if (!isset($_SESSION["usuario_id"])) {

    header("Location: login.php");
    exit;
}


/* =====================================================
   DATOS DEL USUARIO
===================================================== */

$nombreUsuario = $_SESSION["usuario_nombre"];
$rolUsuario = $_SESSION["usuario_rol"];

?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>FieldBook Pro</title>

    <link
        rel="stylesheet"
        href="/Proyecto_LenguajeBaseDatos/frontend/css/estilos.css?v=8"
    >

</head>


<body>


<!-- =====================================================
     ENCABEZADO
===================================================== -->

<header class="encabezado">

    <div class="contenedor encabezado-flex">


        <!-- LOGO / NOMBRE -->

        <div>

            <h1>
                FieldBook Pro
            </h1>

            <p>
                Sistema de reservas de canchas de fútbol
            </p>

        </div>


        <!-- USUARIO -->

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
                href="../backend/usuarios/logout.php"
                class="enlace-inicio"
            >
                Cerrar sesión
            </a>

        </div>


    </div>

</header>


<!-- =====================================================
     CONTENIDO
===================================================== -->

<main class="contenedor">


    <!-- =================================================
         BIENVENIDA
    ================================================== -->

    <section class="cabecera-modulo">

        <p class="ruta-modulo">
            Panel principal
        </p>

        <h2>
            Bienvenido a FieldBook Pro
        </h2>

        <p>
            Consulte la actividad del día y
            seleccione el módulo que desea administrar.
        </p>

    </section>



    <!-- =================================================
         INFORMACIÓN DEL USUARIO
    ================================================== -->

    <section class="panel panel-bienvenida">

        <div>

            <p class="texto-bienvenida">
                Sesión iniciada como
            </p>

            <h2>

                <?php

                echo htmlspecialchars(
                    $nombreUsuario
                );

                ?>

            </h2>


            <span class="etiqueta-rol">

                <?php

                echo htmlspecialchars(
                    $rolUsuario
                );

                ?>

            </span>

        </div>

    </section>



    <!-- =================================================
         RESUMEN DEL DÍA
    ================================================== -->

    <section>

        <div class="titulo-panel">

            <div>

                <h2>
                    Resumen del día
                </h2>

                <p>
                    Información actual del sistema.
                </p>

            </div>

        </div>


        <div class="resumen-dia">


            <!-- RESERVAS -->

            <div class="resumen-card">

                <span class="resumen-titulo">
                    Reservas de hoy
                </span>

                <strong
                    class="resumen-numero"
                    id="resumenReservas"
                >
                    ...
                </strong>

                <span class="resumen-detalle">
                    Reservas activas para hoy
                </span>

            </div>



            <!-- PAGOS -->

            <div class="resumen-card">

                <span class="resumen-titulo">
                    Pagos pendientes
                </span>

                <strong
                    class="resumen-numero"
                    id="resumenPagos"
                >
                    ...
                </strong>

                <span class="resumen-detalle">
                    Transacciones por completar
                </span>

            </div>



            <!-- CANCHAS -->

            <div class="resumen-card">

                <span class="resumen-titulo">
                    Canchas disponibles
                </span>

                <strong
                    class="resumen-numero"
                    id="resumenCanchas"
                >
                    ...
                </strong>

                <span class="resumen-detalle">
                    Disponibles en este momento
                </span>

            </div>


        </div>

    </section>



    <!-- =================================================
         MÓDULOS
    ================================================== -->

    <section class="panel">


        <div class="titulo-panel">

            <div>

                <h2>
                    Módulos del sistema
                </h2>

                <p>
                    Las opciones disponibles dependen
                    de su rol dentro del sistema.
                </p>

            </div>

        </div>



        <div class="modulos">


            <!-- =========================================
                 CLIENTES
            ========================================== -->

            <div class="tarjeta">

                <h3>
                    Clientes
                </h3>

                <p>
                    Registre, consulte,
                    actualice y administre
                    los clientes.
                </p>

                <a
                    href="clientes.php"
                    class="boton"
                >
                    Administrar clientes
                </a>

            </div>



            <!-- =========================================
                 CANCHAS
                 SOLO ADMINISTRADOR
            ========================================== -->

            <?php

            if ($rolUsuario === "ADMINISTRADOR") {

            ?>

                <div class="tarjeta">

                    <h3>
                        Canchas
                    </h3>

                    <p>
                        Administre las canchas,
                        sus tarifas, capacidad
                        y estado.
                    </p>

                    <a
                        href="canchas.php"
                        class="boton"
                    >
                        Administrar canchas
                    </a>

                </div>

            <?php

            }

            ?>



            <!-- =========================================
                 DISPONIBILIDAD
                 ADMIN + RECEPCIONISTA
            ========================================== -->

            <div class="tarjeta tarjeta-destacada">

                <h3>
                    Disponibilidad
                </h3>

                <p>
                    Consulte qué canchas están
                    disponibles según la fecha
                    y hora seleccionadas.
                </p>

                <a
                    href="disponibilidad.php"
                    class="boton"
                >
                    Consultar disponibilidad
                </a>

            </div>



            <!-- =========================================
                 RESERVAS
            ========================================== -->

            <div class="tarjeta">

                <h3>
                    Reservas
                </h3>

                <p>
                    Cree, consulte,
                    modifique y cancele
                    reservaciones.
                </p>

                <a
                    href="reservas.php"
                    class="boton"
                >
                    Administrar reservas
                </a>

            </div>



            <!-- =========================================
                 PAGOS
            ========================================== -->

            <div class="tarjeta">

                <h3>
                    Pagos
                </h3>

                <p>
                    Registre y consulte
                    pagos asociados
                    a reservaciones.
                </p>

                <a
                    href="pagos.php"
                    class="boton"
                >
                    Administrar pagos
                </a>

            </div>



            <!-- =========================================
                 USUARIOS
                 SOLO ADMINISTRADOR
            ========================================== -->

            <?php

            if ($rolUsuario === "ADMINISTRADOR") {

            ?>

                <div class="tarjeta">

                    <h3>
                        Usuarios
                    </h3>

                    <p>
                        Gestione usuarios,
                        roles, estados
                        y accesos.
                    </p>

                    <a
                        href="usuarios.php"
                        class="boton"
                    >
                        Administrar usuarios
                    </a>

                </div>

            <?php

            }

            ?>


        </div>


    </section>



    <!-- =================================================
         FUNCIONES RECEPCIONISTA
    ================================================== -->

    <?php

    if ($rolUsuario === "RECEPCIONISTA") {

    ?>

        <section class="panel">

            <div class="titulo-panel">

                <div>

                    <h2>
                        Funciones de recepción
                    </h2>

                    <p>
                        Operaciones disponibles
                        para su usuario.
                    </p>

                </div>

            </div>


            <p class="texto-informativo">

                Como recepcionista puede registrar
                y administrar clientes, consultar
                la disponibilidad de las canchas,
                gestionar reservas y registrar pagos.

            </p>

        </section>

    <?php

    }

    ?>


</main>



<!-- =====================================================
     JAVASCRIPT
===================================================== -->

<script src="js/dashboard.js?v=2"></script>


</body>

</html>