<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pagos | FieldBook Pro</title>

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
            Panel principal / Pagos
        </p>

        <h2>Gestión de pagos</h2>

        <p>
            Registre y administre los pagos
            asociados a las reservaciones.
        </p>

    </section>

    <section class="panel">

        <div class="titulo-panel">

            <div>
                <h2 id="tituloPago">
                    Registrar pago
                </h2>

                <p>
                    Complete los datos de la transacción.
                </p>
            </div>

        </div>

        <form id="formPago">

            <input
                type="hidden"
                id="idPago"
            >

            <div class="form-grid">

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
                        Método de pago
                    </label>

                    <select id="metodoPago">

                        <option value="EFECTIVO">
                            Efectivo
                        </option>

                        <option value="SINPE">
                            SINPE
                        </option>

                        <option value="TARJETA">
                            Tarjeta
                        </option>

                    </select>

                </div>

                <div class="campo">

                    <label for="estadoPago">
                        Estado
                    </label>

                    <select id="estadoPago">

                        <option value="PENDIENTE">
                            Pendiente
                        </option>

                        <option value="COMPLETADO">
                            Completado
                        </option>

                        <option value="RECHAZADO">
                            Rechazado
                        </option>

                    </select>

                </div>

            </div>

            <div class="acciones-formulario">

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

            </div>

        </form>

        <p id="mensajePago"></p>

    </section>

    <section class="panel">

        <div class="titulo-panel">

            <div>
                <h2>Pagos registrados</h2>

                <p>
                    Consulte y administre los pagos existentes.
                </p>
            </div>

        </div>

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

<script src="js/pagos.js?v=2"></script>

</body>

</html>