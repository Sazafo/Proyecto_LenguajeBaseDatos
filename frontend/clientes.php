<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Clientes | FieldBook Pro</title>

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
            Panel principal / Clientes
        </p>

        <h2>Gestión de clientes</h2>

        <p>
            Registre, consulte y administre
            la información de los clientes.
        </p>

    </section>

    <section class="panel">

        <div class="titulo-panel">
            <div>
                <h2 id="tituloCliente">
                    Registrar cliente
                </h2>

                <p>
                    Complete los datos personales del cliente.
                </p>
            </div>
        </div>

        <form id="formCliente">

            <input type="hidden" id="idCliente">

            <div class="form-grid">

                <div class="campo">
                    <label for="cedula">
                        Cédula
                    </label>

                    <input
                        type="text"
                        id="cedula"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="nombre">
                        Nombre
                    </label>

                    <input
                        type="text"
                        id="nombre"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="apellidos">
                        Apellidos
                    </label>

                    <input
                        type="text"
                        id="apellidos"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="correo">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="correo"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="telefono">
                        Teléfono
                    </label>

                    <input
                        type="text"
                        id="telefono"
                        required
                    >
                </div>

            </div>

            <div class="acciones-formulario">

                <button
                    type="submit"
                    id="btnGuardarCliente"
                >
                    Guardar cliente
                </button>

                <button
                    type="button"
                    id="btnCancelarCliente"
                    class="boton-secundario"
                >
                    Cancelar
                </button>

            </div>

        </form>

        <p id="mensajeCliente"></p>

    </section>

    <section class="panel">

        <div class="titulo-panel">
            <div>
                <h2>Clientes registrados</h2>

                <p>
                    Consulte y administre los clientes existentes.
                </p>
            </div>
        </div>

        <div class="tabla-contenedor">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody id="tablaClientes"></tbody>

            </table>

        </div>

    </section>

</main>

<script src="js/clientes.js?v=2"></script>

</body>

</html>