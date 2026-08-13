const formularioCliente =
    document.getElementById("formCliente");

const tablaClientes =
    document.getElementById("tablaClientes");

const mensajeCliente =
    document.getElementById("mensajeCliente");

const btnCancelarCliente =
    document.getElementById("btnCancelarCliente");

const btnGuardarCliente =
    document.getElementById("btnGuardarCliente");

const tituloCliente =
    document.getElementById("tituloCliente");

let clientes = [];


/* =====================================================
   LISTAR CLIENTES
===================================================== */

async function cargarClientes() {

    try {

        const respuesta = await fetch(
            "../backend/clientes/listar.php"
        );

        const datos = await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudieron cargar los clientes."
            );
        }

        clientes = datos.clientes;

        mostrarClientes();

    } catch (error) {

        console.error(
            "Error al cargar clientes:",
            error
        );

        mostrarMensajeCliente(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   MOSTRAR CLIENTES
===================================================== */

function mostrarClientes() {

    tablaClientes.innerHTML = "";

    if (clientes.length === 0) {

        tablaClientes.innerHTML = `
            <tr>
                <td colspan="7">
                    No existen clientes registrados.
                </td>
            </tr>
        `;

        return;
    }

    clientes.forEach(function (cliente) {

        const fila =
            document.createElement("tr");

        fila.innerHTML = `
            <td>${cliente.id}</td>
            <td>${cliente.cedula}</td>
            <td>${cliente.nombre}</td>
            <td>${cliente.apellidos}</td>
            <td>${cliente.correo}</td>
            <td>${cliente.telefono}</td>

            <td>
                <button
                    type="button"
                    onclick="editarCliente(${cliente.id})"
                >
                    Editar
                </button>

                <button
                    type="button"
                    class="boton-eliminar"
                    onclick="eliminarCliente(${cliente.id})"
                >
                    Eliminar
                </button>
            </td>
        `;

        tablaClientes.appendChild(fila);
    });
}


/* =====================================================
   OBTENER DATOS
===================================================== */

function obtenerDatosCliente() {

    return {

        cedula:
            document
                .getElementById("cedula")
                .value
                .trim(),

        nombre:
            document
                .getElementById("nombre")
                .value
                .trim(),

        apellidos:
            document
                .getElementById("apellidos")
                .value
                .trim(),

        correo:
            document
                .getElementById("correo")
                .value
                .trim(),

        telefono:
            document
                .getElementById("telefono")
                .value
                .trim()
    };
}


/* =====================================================
   VALIDAR
===================================================== */

function validarCliente(cliente) {

    if (
        cliente.cedula === "" ||
        cliente.nombre === "" ||
        cliente.apellidos === "" ||
        cliente.correo === "" ||
        cliente.telefono === ""
    ) {

        mostrarMensajeCliente(
            "Debe completar todos los campos.",
            "error"
        );

        return false;
    }

    return true;
}


/* =====================================================
   CREAR CLIENTE
===================================================== */

async function registrarCliente(datosCliente) {

    try {

        const respuesta = await fetch(
            "../backend/clientes/crear.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify(
                        datosCliente
                    )
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo registrar el cliente."
            );
        }

        limpiarFormularioCliente();

        await cargarClientes();

        mostrarMensajeCliente(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al registrar:",
            error
        );

        mostrarMensajeCliente(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   ACTUALIZAR CLIENTE
===================================================== */

async function actualizarCliente(
    id,
    datosCliente
) {

    try {

        const respuesta = await fetch(
            "../backend/clientes/actualizar.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify({
                        id: id,
                        ...datosCliente
                    })
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo actualizar el cliente."
            );
        }

        limpiarFormularioCliente();

        await cargarClientes();

        mostrarMensajeCliente(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al actualizar:",
            error
        );

        mostrarMensajeCliente(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   SUBMIT
===================================================== */

formularioCliente.addEventListener(
    "submit",
    async function (evento) {

        evento.preventDefault();

        const idCliente =
            document
                .getElementById("idCliente")
                .value;

        const datosCliente =
            obtenerDatosCliente();

        if (!validarCliente(datosCliente)) {
            return;
        }

        if (idCliente === "") {

            await registrarCliente(
                datosCliente
            );

        } else {

            await actualizarCliente(
                Number(idCliente),
                datosCliente
            );
        }
    }
);


/* =====================================================
   EDITAR
===================================================== */

function editarCliente(id) {

    const cliente =
        clientes.find(
            function (item) {
                return item.id === id;
            }
        );

    if (!cliente) {
        return;
    }

    document
        .getElementById("idCliente")
        .value = cliente.id;

    document
        .getElementById("cedula")
        .value = cliente.cedula;

    document
        .getElementById("nombre")
        .value = cliente.nombre;

    document
        .getElementById("apellidos")
        .value = cliente.apellidos;

    document
        .getElementById("correo")
        .value = cliente.correo;

    document
        .getElementById("telefono")
        .value = cliente.telefono;

    tituloCliente.textContent =
        "Editar cliente";

    btnGuardarCliente.textContent =
        "Actualizar cliente";

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}


/* =====================================================
   ELIMINAR
===================================================== */

async function eliminarCliente(id) {

    const cliente =
        clientes.find(
            function (item) {
                return item.id === id;
            }
        );

    if (!cliente) {
        return;
    }

    const confirmar = confirm(
        `¿Desea eliminar al cliente "${cliente.nombre} ${cliente.apellidos}"?`
    );

    if (!confirmar) {
        return;
    }

    try {

        const respuesta = await fetch(
            "../backend/clientes/eliminar.php",
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
                "No se pudo eliminar el cliente."
            );
        }

        await cargarClientes();

        mostrarMensajeCliente(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al eliminar:",
            error
        );

        mostrarMensajeCliente(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   LIMPIAR
===================================================== */

function limpiarFormularioCliente() {

    formularioCliente.reset();

    document
        .getElementById("idCliente")
        .value = "";

    tituloCliente.textContent =
        "Registrar cliente";

    btnGuardarCliente.textContent =
        "Guardar cliente";
}


/* =====================================================
   MENSAJES
===================================================== */

function mostrarMensajeCliente(
    texto,
    tipo
) {

    mensajeCliente.textContent =
        texto;

    mensajeCliente.className =
        tipo;
}


/* =====================================================
   CANCELAR
===================================================== */

btnCancelarCliente.addEventListener(
    "click",
    function () {

        limpiarFormularioCliente();

        mensajeCliente.textContent = "";
        mensajeCliente.className = "";
    }
);


/* =====================================================
   INICIO
===================================================== */

cargarClientes();