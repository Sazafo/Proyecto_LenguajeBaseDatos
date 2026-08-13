<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Canchas | FieldBook Pro</title>

    <link
        rel="stylesheet"
        href="/Proyecto_LenguajeBaseDatos/frontend/css/estilos.css?v=4"
    >
</head>

<body>

<header class="encabezado">

    <div class="contenedor encabezado-flex">

        <div>
            <h1>FieldBook Pro</h1>
            <p>Sistema de reservas de canchas de fútbol</p>
        </div>

        <a
            href="index.php"
            class="enlace-inicio"
        >
            Inicio
        </a>

    </div>

</header>


<main class="contenedor">

    <!-- CABECERA DEL MÓDULO -->

    <section class="cabecera-modulo">

        <p class="ruta-modulo">
            Panel principal / Canchas
        </p>

        <h2>Gestión de canchas</h2>

        <p>
            Administre el catálogo, tarifa,
            capacidad y estado de las canchas.
        </p>

    </section>


    <!-- FORMULARIO -->

    <section class="panel">

        <div class="titulo-panel">

            <div>

                <h2 id="tituloFormulario">
                    Registrar cancha
                </h2>

                <p>
                    Complete la información de la cancha.
                </p>

            </div>

        </div>


        <form id="formCancha">

            <!-- ID OCULTO PARA EDICIÓN -->

            <input
                type="hidden"
                id="idCancha"
            >


            <div class="form-grid">


                <!-- NOMBRE -->

                <div class="campo">

                    <label for="nombreCancha">
                        Nombre de la cancha
                    </label>

                    <input
                        type="text"
                        id="nombreCancha"
                        required
                    >

                </div>


                <!-- TIPO -->

                <div class="campo">

                    <label for="tipo">
                        Tipo de cancha
                    </label>

                    <select
                        id="tipo"
                        required
                    >

                        <option value="">
                            Seleccione
                        </option>

                        <option value="Fútbol 5">
                            Fútbol 5
                        </option>

                        <option value="Fútbol 7">
                            Fútbol 7
                        </option>

                        <option value="Fútbol 11">
                            Fútbol 11
                        </option>

                    </select>

                </div>


                <!-- SUPERFICIE -->

                <div class="campo">

                    <label for="superficie">
                        Superficie
                    </label>

                    <select
                        id="superficie"
                        required
                    >

                        <option value="">
                            Seleccione
                        </option>

                        <option value="Césped sintético">
                            Césped sintético
                        </option>

                        <option value="Césped natural">
                            Césped natural
                        </option>

                        <option value="Piso de futsal">
                            Piso de futsal
                        </option>

                    </select>

                </div>


                <!-- CAPACIDAD -->

                <div class="campo">

                    <label for="capacidad">
                        Capacidad de jugadores
                    </label>

                    <input
                        type="number"
                        id="capacidad"
                        min="1"
                        required
                    >

                </div>


                <!-- TARIFA -->

                <div class="campo">

                    <label for="tarifa">
                        Tarifa por hora
                    </label>

                    <input
                        type="number"
                        id="tarifa"
                        min="1"
                        step="0.01"
                        required
                    >

                </div>


                <!-- ESTADO -->

                <div class="campo">

                    <label for="estado">
                        Estado
                    </label>

                    <select
                        id="estado"
                        required
                    >

                        <option value="ACTIVA">
                            Activa
                        </option>

                        <option value="INACTIVA">
                            Inactiva
                        </option>

                        <option value="MANTENIMIENTO">
                            Mantenimiento
                        </option>

                    </select>

                </div>

            </div>


            <!-- BOTONES -->

            <div class="acciones-formulario">

                <button
                    type="submit"
                    id="btnGuardarCancha"
                >
                    Guardar cancha
                </button>

                <button
                    type="button"
                    id="btnCancelarCancha"
                    class="boton-secundario"
                >
                    Cancelar
                </button>

            </div>

        </form>


        <!-- MENSAJES -->

        <p id="mensajeCancha"></p>

    </section>


    <!-- TABLA DE CANCHAS -->

    <section class="panel">

        <div class="titulo-panel">

            <div>

                <h2>
                    Canchas registradas
                </h2>

                <p>
                    Consulte y administre
                    las canchas existentes.
                </p>

            </div>

        </div>


        <div class="tabla-contenedor">

            <table>

                <thead>

                    <tr>

                        <th>ID</th>

                        <th>
                            Nombre
                        </th>

                        <th>
                            Tipo
                        </th>

                        <th>
                            Superficie
                        </th>

                        <th>
                            Capacidad
                        </th>

                        <th>
                            Tarifa
                        </th>

                        <th>
                            Estado
                        </th>

                        <th>
                            Acciones
                        </th>

                    </tr>

                </thead>


                <tbody id="tablaCanchas">

                </tbody>

            </table>

        </div>

    </section>

</main>


<!-- JAVASCRIPT -->

<script src="js/canchas.js?v=2"></script>

</body>

</html>