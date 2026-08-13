<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Canchas | FieldBook Pro</title>

    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>

    <header class="encabezado">
        <div class="contenedor">
            <h1>FieldBook Pro</h1>
            <p>Gestión de canchas</p>
        </div>
    </header>

    <main class="contenedor">

        <a href="index.php" class="boton-volver">
            Volver al inicio
        </a>

        <section class="panel">

            <h2 id="tituloFormulario">Registrar cancha</h2>

            <form id="formCancha">

                <input
                    type="hidden"
                    id="idCancha"
                >

                <div class="campo">
                    <label for="nombreCancha">
                        Nombre de la cancha
                    </label>

                    <input
                        type="text"
                        id="nombreCancha"
                        maxlength="60"
                        required
                    >
                </div>

                <div class="campo">
                    <label for="tipo">
                        Tipo de cancha
                    </label>

                    <select id="tipo" required>
                        <option value="">
                            Seleccione un tipo
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

                <div class="campo">
                    <label for="superficie">
                        Superficie
                    </label>

                    <select id="superficie" required>
                        <option value="">
                            Seleccione una superficie
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

                <div class="campo">
                    <label for="capacidad">
                        Capacidad de jugadores
                    </label>

                    <input
                        type="number"
                        id="capacidad"
                        min="1"
                        max="99"
                        required
                    >
                </div>

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

                <div class="campo">
                    <label for="estado">
                        Estado
                    </label>

                    <select id="estado" required>
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

            </form>

            <p id="mensajeCancha"></p>

        </section>

        <section class="panel">

            <h2>Canchas registradas</h2>

            <div class="tabla-contenedor">

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Superficie</th>
                            <th>Capacidad</th>
                            <th>Tarifa</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaCanchas"></tbody>
                </table>

            </div>

        </section>

    </main>

    <script src="js/canchas.js"></script>

</body>

</html>