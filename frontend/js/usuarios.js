const formularioUsuario =
    document.getElementById("formUsuario");

const tablaUsuarios =
    document.getElementById("tablaUsuarios");

const mensajeUsuario =
    document.getElementById("mensajeUsuario");

const btnCancelarUsuario =
    document.getElementById("btnCancelarUsuario");

const btnGuardarUsuario =
    document.getElementById("btnGuardarUsuario");

const tituloUsuario =
    document.getElementById("tituloUsuario");

const nombreUsuario =
    document.getElementById("nombreUsuario");

const apellidosUsuario =
    document.getElementById("apellidosUsuario");

const correoUsuario =
    document.getElementById("correoUsuario");

const contrasenaUsuario =
    document.getElementById("contrasenaUsuario");

const rolUsuario =
    document.getElementById("rolUsuario");

const estadoUsuario =
    document.getElementById("estadoUsuario");

let usuarios = [];


/* =====================================================
   LISTAR USUARIOS
===================================================== */

async function cargarUsuarios() {

    try {

        const respuesta = await fetch(
            "../backend/usuarios/listar.php"
        );

        const datos = await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudieron cargar los usuarios."
            );
        }

        usuarios = datos.usuarios;

        mostrarUsuarios();

    } catch (error) {

        console.error(
            "Error al cargar usuarios:",
            error
        );

        mostrarMensajeUsuario(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   MOSTRAR USUARIOS
===================================================== */

function mostrarUsuarios() {

    tablaUsuarios.innerHTML = "";

    if (usuarios.length === 0) {

        tablaUsuarios.innerHTML = `
            <tr>
                <td colspan="7">
                    No existen usuarios registrados.
                </td>
            </tr>
        `;

        return;
    }

    usuarios.forEach(
        function (usuario) {

            const fila =
                document.createElement("tr");

            fila.innerHTML = `
                <td>${usuario.id}</td>

                <td>${usuario.nombre}</td>

                <td>${usuario.apellidos}</td>

                <td>${usuario.correo}</td>

                <td>${usuario.rol}</td>

                <td>${usuario.estado}</td>

                <td>

                    <button
                        type="button"
                        onclick="editarUsuario(${usuario.id})"
                    >
                        Editar
                    </button>

                    <button
                        type="button"
                        class="boton-eliminar"
                        onclick="eliminarUsuario(${usuario.id})"
                    >
                        Eliminar
                    </button>

                </td>
            `;

            tablaUsuarios.appendChild(
                fila
            );
        }
    );
}


/* =====================================================
   OBTENER DATOS
===================================================== */

function obtenerDatosUsuario() {

    return {

        nombre:
            nombreUsuario
                .value
                .trim(),

        apellidos:
            apellidosUsuario
                .value
                .trim(),

        correo:
            correoUsuario
                .value
                .trim(),

        contrasena:
            contrasenaUsuario
                .value,

        rol:
            rolUsuario
                .value,

        estado:
            estadoUsuario
                .value
    };
}


/* =====================================================
   VALIDAR
===================================================== */

function validarUsuario(
    usuario,
    esNuevo
) {

    if (usuario.nombre === "") {

        mostrarMensajeUsuario(
            "Debe ingresar el nombre.",
            "error"
        );

        return false;
    }

    if (usuario.apellidos === "") {

        mostrarMensajeUsuario(
            "Debe ingresar los apellidos.",
            "error"
        );

        return false;
    }

    if (usuario.correo === "") {

        mostrarMensajeUsuario(
            "Debe ingresar el correo.",
            "error"
        );

        return false;
    }

    if (
        esNuevo &&
        usuario.contrasena === ""
    ) {

        mostrarMensajeUsuario(
            "Debe ingresar una contraseña.",
            "error"
        );

        return false;
    }

    return true;
}


/* =====================================================
   CREAR USUARIO
===================================================== */

async function registrarUsuario(
    datosUsuario
) {

    try {

        const respuesta = await fetch(
            "../backend/usuarios/crear.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify(
                        datosUsuario
                    )
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo registrar el usuario."
            );
        }

        limpiarFormularioUsuario();

        await cargarUsuarios();

        mostrarMensajeUsuario(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al registrar usuario:",
            error
        );

        mostrarMensajeUsuario(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   ACTUALIZAR USUARIO
===================================================== */

async function actualizarUsuario(
    id,
    datosUsuario
) {

    try {

        const respuesta = await fetch(
            "../backend/usuarios/actualizar.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify({
                        id: id,

                        nombre:
                            datosUsuario.nombre,

                        apellidos:
                            datosUsuario.apellidos,

                        correo:
                            datosUsuario.correo,

                        rol:
                            datosUsuario.rol,

                        estado:
                            datosUsuario.estado
                    })
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo actualizar el usuario."
            );
        }

        limpiarFormularioUsuario();

        await cargarUsuarios();

        mostrarMensajeUsuario(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al actualizar usuario:",
            error
        );

        mostrarMensajeUsuario(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   SUBMIT
===================================================== */

formularioUsuario.addEventListener(
    "submit",
    async function (evento) {

        evento.preventDefault();

        const idUsuario =
            document
                .getElementById(
                    "idUsuario"
                )
                .value;

        const datosUsuario =
            obtenerDatosUsuario();

        const esNuevo =
            idUsuario === "";

        if (
            !validarUsuario(
                datosUsuario,
                esNuevo
            )
        ) {
            return;
        }

        if (esNuevo) {

            await registrarUsuario(
                datosUsuario
            );

        } else {

            await actualizarUsuario(
                Number(idUsuario),
                datosUsuario
            );
        }
    }
);


/* =====================================================
   EDITAR
===================================================== */

function editarUsuario(id) {

    const usuario =
        usuarios.find(
            function (item) {
                return item.id === id;
            }
        );

    if (!usuario) {
        return;
    }

    document.getElementById(
        "idUsuario"
    ).value = usuario.id;

    nombreUsuario.value =
        usuario.nombre;

    apellidosUsuario.value =
        usuario.apellidos;

    correoUsuario.value =
        usuario.correo;

    contrasenaUsuario.value =
        "";

    rolUsuario.value =
        usuario.rol;

    estadoUsuario.value =
        usuario.estado;

    tituloUsuario.textContent =
        "Editar usuario";

    btnGuardarUsuario.textContent =
        "Actualizar usuario";

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}


/* =====================================================
   ELIMINAR
===================================================== */

async function eliminarUsuario(id) {

    const usuario =
        usuarios.find(
            function (item) {
                return item.id === id;
            }
        );

    if (!usuario) {
        return;
    }

    const confirmar = confirm(
        `¿Desea eliminar al usuario "${usuario.nombre} ${usuario.apellidos}"?`
    );

    if (!confirmar) {
        return;
    }

    try {

        const respuesta = await fetch(
            "../backend/usuarios/eliminar.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify({
                        id: id
                    })
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo eliminar el usuario."
            );
        }

        await cargarUsuarios();

        mostrarMensajeUsuario(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al eliminar usuario:",
            error
        );

        mostrarMensajeUsuario(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   LIMPIAR
===================================================== */

function limpiarFormularioUsuario() {

    formularioUsuario.reset();

    document.getElementById(
        "idUsuario"
    ).value = "";

    rolUsuario.value =
        "ADMINISTRADOR";

    estadoUsuario.value =
        "ACTIVO";

    tituloUsuario.textContent =
        "Registrar usuario";

    btnGuardarUsuario.textContent =
        "Guardar usuario";
}


/* =====================================================
   MENSAJES
===================================================== */

function mostrarMensajeUsuario(
    texto,
    tipo
) {

    mensajeUsuario.textContent =
        texto;

    mensajeUsuario.className =
        tipo;
}


/* =====================================================
   CANCELAR
===================================================== */

btnCancelarUsuario.addEventListener(
    "click",
    function () {

        limpiarFormularioUsuario();

        mensajeUsuario.textContent =
            "";

        mensajeUsuario.className =
            "";
    }
);


/* =====================================================
   INICIO
===================================================== */

cargarUsuarios();