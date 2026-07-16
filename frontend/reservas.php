<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reservas | FieldBook Pro</title>

    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <header class="encabezado">
        <div class="contenedor">
            <h1>FieldBook Pro</h1>
            <p>Gestión de reservas</p>
        </div>
    </header>

    <main class="contenedor">

        <a href="index.php" class="boton-volver">
            Volver al inicio
        </a>

        <section class="panel">

            <h2>Registrar reserva</h2>

            <form id="formReserva">

                <input
                    type="hidden"
                    id="idReserva"
                >

                <div class="campo">
                    <label for="clienteReserva">
                        Cliente
                    </label>

                    <select id="clienteReserva" required>
                        <option value="">
                            Seleccione un cliente
                        </option>

                        <option value="1">
                            Santiago Zamora Fonseca
                        </option>

                        <option value="2">
                            Brenda Pérez León
                        </option>
                    </select>
                </div>

                <div class="campo">
                    <label for="canchaReserva">
                        Cancha
                    </label>

                    <select id="canchaReserva" required>
                        <option value="">
                            Seleccione una cancha
                        </option>

                        <option
                            value="1"
                            data-tarifa="25000"
                        >
                            Cancha Central
                        </option>

                        <option
                            value="2"
                            data-tarifa="35000"
                        >
                            Cancha Norte
                        </option>
                    </select>
                </div>

                <div class="campo">
                    <label for="fechaReserva">
                        Fecha
                    </label>

                    <input
                        type="date"
                        id="fechaReserva"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="horaInicio">
                        Hora de inicio
                    </label>

                    <input
                        type="time"
                        id="horaInicio"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="horaFin">
                        Hora de finalización
                    </label>

                    <input
                        type="time"
                        id="horaFin"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="estadoReserva">
                        Estado
                    </label>

                    <select id="estadoReserva" required>
                        <option value="PENDIENTE">
                            Pendiente
                        </option>

                        <option value="CONFIRMADA">
                            Confirmada
                        </option>

                        <option value="CANCELADA">
                            Cancelada
                        </option>
                    </select>
                </div>

                <div class="campo">
                    <label for="totalReserva">
                        Total de la reserva
                    </label>

                    <input
                        type="text"
                        id="totalReserva"
                        readonly
                    >
                </div>

                <button type="submit">
                    Guardar reserva
                </button>

                <button
                    type="button"
                    id="btnCancelarReserva"
                    class="boton-secundario"
                >
                    Cancelar
                </button>

            </form>

            <p id="mensajeReserva"></p>

        </section>

        <section class="panel">

            <h2>Reservas registradas</h2>

            <div class="tabla-contenedor">

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Cancha</th>
                            <th>Fecha</th>
                            <th>Horario</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaReservas"></tbody>
                </table>

            </div>

        </section>

    </main>

    <script src="js/reservas.js"></script>

</body>

</html>