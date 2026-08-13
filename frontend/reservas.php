<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reservas | FieldBook Pro</title>

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

        <a href="index.php" class="enlace-inicio">
            Inicio
        </a>

    </div>

</header>

<main class="contenedor">

    <section class="cabecera-modulo">

        <p class="ruta-modulo">
            Panel principal / Reservas
        </p>

        <h2>Gestión de reservas</h2>

        <p>
            Cree, consulte, modifique y cancele
            las reservas de las canchas.
        </p>

    </section>

    <section class="panel">

        <div class="titulo-panel">

            <div>
                <h2 id="tituloReserva">
                    Registrar reserva
                </h2>

                <p>
                    Seleccione cliente, cancha,
                    horario y estado.
                </p>
            </div>

        </div>

        <form id="formReserva">

            <input
                type="hidden"
                id="idReserva"
            >

            <div class="form-grid">

                <div class="campo">

                    <label for="clienteReserva">
                        Cliente
                    </label>

                    <select
                        id="clienteReserva"
                        required
                    ></select>

                </div>

                <div class="campo">

                    <label for="canchaReserva">
                        Cancha
                    </label>

                    <select
                        id="canchaReserva"
                        required
                    ></select>

                </div>

                <div class="campo">

                    <label for="inicioReserva">
                        Fecha y hora de inicio
                    </label>

                    <input
                        type="datetime-local"
                        id="inicioReserva"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="finReserva">
                        Fecha y hora final
                    </label>

                    <input
                        type="datetime-local"
                        id="finReserva"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="estadoReserva">
                        Estado
                    </label>

                    <select id="estadoReserva">

                        <option value="PENDIENTE">
                            Pendiente
                        </option>

                        <option value="CONFIRMADA">
                            Confirmada
                        </option>

                        <option value="FINALIZADA">
                            Finalizada
                        </option>

                        <option value="CANCELADA">
                            Cancelada
                        </option>

                    </select>

                </div>

            </div>

            <div class="acciones-formulario">

                <button
                    type="submit"
                    id="btnGuardarReserva"
                >
                    Guardar reserva
                </button>

                <button
                    type="button"
                    id="btnCancelarEdicion"
                    class="boton-secundario"
                >
                    Cancelar
                </button>

            </div>

        </form>

        <p id="mensajeReserva"></p>

    </section>

    <section class="panel">

        <div class="titulo-panel">

            <div>
                <h2>Reservas registradas</h2>

                <p>
                    Consulte las reservas existentes.
                </p>
            </div>

        </div>

        <div class="tabla-contenedor">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Cancha</th>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>

                </thead>

                <tbody id="tablaReservas"></tbody>

            </table>

        </div>

    </section>

</main>

<script src="js/reservas.js?v=2"></script>

</body>

</html>