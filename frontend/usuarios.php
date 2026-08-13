<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Usuarios | FieldBook Pro</title>

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
            Panel principal / Usuarios
        </p>

        <h2>Gestión de usuarios</h2>

        <p>
            Administre usuarios, roles
            y accesos al sistema.
        </p>

    </section>

    <section class="panel">

        <div class="titulo-panel">

            <div>
                <h2 id="tituloUsuario">
                    Registrar usuario
                </h2>

                <p>
                    Complete la información de acceso.
                </p>
            </div>

        </div>

        <form id="formUsuario">

            <input
                type="hidden"
                id="idUsuario"
            >

            <div class="form-grid">

                <div class="campo">

                    <label for="nombreUsuario">
                        Nombre
                    </label>

                    <input
                        type="text"
                        id="nombreUsuario"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="apellidosUsuario">
                        Apellidos
                    </label>

                    <input
                        type="text"
                        id="apellidosUsuario"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="correoUsuario">
                        Correo electrónico
                    </label>

                    <input
                        type="email"
                        id="correoUsuario"
                        required
                    >

                </div>

                <div class="campo">

                    <label for="contrasenaUsuario">
                        Contraseña
                    </label>

                    <input
                        type="password"
                        id="contrasenaUsuario"
                    >

                </div>

                <div class="campo">

                    <label for="rolUsuario">
                        Rol
                    </label>

                    <select id="rolUsuario">

                        <option value="ADMINISTRADOR">
                            Administrador
                        </option>

                        <option value="RECEPCIONISTA">
                            Recepcionista
                        </option>

                    </select>

                </div>

                <div class="campo">

                    <label for="estadoUsuario">
                        Estado
                    </label>

                    <select id="estadoUsuario">

                        <option value="ACTIVO">
                            Activo
                        </option>

                        <option value="INACTIVO">
                            Inactivo
                        </option>

                    </select>

                </div>

            </div>

            <div class="acciones-formulario">

                <button
                    type="submit"
                    id="btnGuardarUsuario"
                >
                    Guardar usuario
                </button>

                <button
                    type="button"
                    id="btnCancelarUsuario"
                    class="boton-secundario"
                >
                    Cancelar
                </button>

            </div>

        </form>

        <p id="mensajeUsuario"></p>

    </section>

    <section class="panel">

        <div class="titulo-panel">

            <div>
                <h2>Usuarios registrados</h2>

                <p>
                    Consulte usuarios, roles y estados.
                </p>
            </div>

        </div>

        <div class="tabla-contenedor">

            <table>

                <thead>

                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellidos</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>

                </thead>

                <tbody id="tablaUsuarios"></tbody>

            </table>

        </div>

    </section>

</main>

<script src="js/usuarios.js?v=2"></script>

</body>

</html>