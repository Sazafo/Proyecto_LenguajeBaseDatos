<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Pagos | FieldBook Pro</title>

    <link
        rel="stylesheet"
        href="css/estilos.css"
    >
</head>

<body>

    <header class="encabezado">
        <div class="contenedor">
            <h1>FieldBook Pro</h1>
            <p>Gestión de pagos</p>
        </div>
    </header>

    <main class="contenedor">

        <a
            href="index.php"
            class="boton-volver"
        >
            Volver al inicio
        </a>

        <!-- Formulario de pagos -->
        <section class="panel">

            <h2 id="tituloPago">
                Registrar pago
            </h2>

            <form id="formPago">

                <input
                    type="hidden"
                    id="idPago"
                >

                <div class="campo">
                    <label for="reservaPago">
                        Reserva
                    </label>

                    <select
                        id="reservaPago"
                        required
                    ></select>
                </div>

                <div class="campo">
                    <label for="montoPago">
                        Monto
                    </label>

                    <input
                        type="number"
                        id="montoPago"
                        min="0.01"
                        step="0.01"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="metodoPago">
                        Método
                    </label>

                    <select id="metodoPago">
                        <option value="EFECTIVO">
                            EFECTIVO
                        </option>

                        <option value="SINPE">
                            SINPE
                        </option>

                        <option value="TARJETA">
                            TARJETA
                        </option>
                    </select>
                </div>

                <div class="campo">
                    <label for="estadoPago">
                        Estado
                    </label>

                    <select id="estadoPago">

                        <option value="PENDIENTE">
                            PENDIENTE
                        </option>

                        <option value="COMPLETADO">
                            COMPLETADO
                        </option>

                        <option value="RECHAZADO">
                            RECHAZADO
                        </option>

                    </select>
                </div>

                <button
                    type="submit"
                    id="btnGuardarPago"
                >
                    Guardar pago
                </button>

                <button
                    type="button"
                    id="btnCancelarPago"
                    class="boton-secundario"
                >
                    Cancelar
                </button>

            </form>

            <p id="mensajePago"></p>

        </section>

        <!-- Tabla de pagos -->
        <section class="panel">

            <h2>
                Pagos registrados
            </h2>

            <div class="tabla-contenedor">

                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Reserva</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaPagos"></tbody>

                </table>

            </div>

        </section>

    </main>

    <script src="js/pagos.js"></script>

</body>

</html>