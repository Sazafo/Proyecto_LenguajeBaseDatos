<?php

session_start();

if (isset($_SESSION["usuario_id"])) {

    header(
        "Location: index.php"
    );

    exit;
}

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
        Iniciar sesión | FieldBook Pro
    </title>

    <link
        rel="stylesheet"
        href="/Proyecto_LenguajeBaseDatos/frontend/css/estilos.css?v=5"
    >

</head>

<body>


<header class="encabezado">

    <div class="contenedor">

        <h1>
            FieldBook Pro
        </h1>

        <p>
            Sistema de reservas de canchas de fútbol
        </p>

    </div>

</header>


<main class="contenedor">

    <section
        class="panel"
        style="
            max-width: 500px;
            margin: 60px auto;
        "
    >

        <div class="titulo-panel">

            <div>

                <h2>
                    Iniciar sesión
                </h2>

                <p>
                    Ingrese sus credenciales
                    para acceder al sistema.
                </p>

            </div>

        </div>


        <form id="formLogin">

            <div class="campo">

                <label for="correoLogin">
                    Correo electrónico
                </label>

                <input
                    type="email"
                    id="correoLogin"
                    required
                >

            </div>


            <div class="campo">

                <label for="contrasenaLogin">
                    Contraseña
                </label>

                <input
                    type="password"
                    id="contrasenaLogin"
                    required
                >

            </div>


            <button
                type="submit"
                style="width:100%;"
            >
                Ingresar
            </button>

        </form>


        <p id="mensajeLogin"></p>

    </section>

</main>


<script src="js/login.js?v=2"></script>

</body>

</html>