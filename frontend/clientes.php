<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Clientes | FieldBook Pro</title>

    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <header class="encabezado">
        <h1>FieldBook Pro</h1>
        <p>Gestión de clientes</p>
    </header>

    <main class="contenedor">

        <section class="panel">

            <h2>Registrar cliente</h2>

            <form id="formCliente">

                <input
                    type="hidden"
                    id="idCliente"
                >

                <div class="campo">
                    <label for="cedula">Cédula</label>

                    <input
                        type="text"
                        id="cedula"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="nombre">Nombre</label>

                    <input
                        type="text"
                        id="nombre"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="apellidos">Apellidos</label>

                    <input
                        type="text"
                        id="apellidos"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="correo">Correo</label>

                    <input
                        type="email"
                        id="correo"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="telefono">Teléfono</label>

                    <input
                        type="text"
                        id="telefono"
                        required
                    >
                </div>

                <button type="submit">
                    Guardar cliente
                </button>

                <button
                    type="button"
                    id="btnCancelar"
                    class="boton-secundario"
                >
                    Cancelar
                </button>

            </form>

            <p id="mensaje"></p>

        </section>

        <section class="panel">

            <h2>Clientes registrados</h2>

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

        </section>

        <a href="index.php" class="boton-volver">
    Volver al inicio
</a>

    </main>

    <script src="js/clientes.js"></script>

</body>
</html>