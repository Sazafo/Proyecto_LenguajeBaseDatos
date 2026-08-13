const formularioCancha =
    document.getElementById("formCancha");

const tablaCanchas =
    document.getElementById("tablaCanchas");

const mensajeCancha =
    document.getElementById("mensajeCancha");

const btnCancelarCancha =
    document.getElementById("btnCancelarCancha");

const btnGuardarCancha =
    document.getElementById("btnGuardarCancha");

const tituloFormulario =
    document.getElementById("tituloFormulario");

let canchas = [];


/* =========================================================
   LISTAR
========================================================= */

async function cargarCanchas() {

    try {

        const respuesta = await fetch(
            "../backend/canchas/listar.php"
        );

        const datos = await respuesta.json();

        if (!datos.exito) {
            throw new Error(datos.mensaje);
        }

        canchas = datos.canchas;

        mostrarCanchas();

    } catch (error) {

        mostrarMensaje(
            error.message,
            "error"
        );
    }
}


/* =========================================================
   MOSTRAR TABLA
========================================================= */

function mostrarCanchas() {

    tablaCanchas.innerHTML = "";

    if (canchas.length === 0) {

        tablaCanchas.innerHTML = `
            <tr>
                <td colspan="8">
                    No existen canchas registradas.
                </td>
            </tr>
        `;

        return;
    }

    canchas.forEach(function (cancha) {

        const fila =
            document.createElement("tr");

        fila.innerHTML = `
            <td>${cancha.id}</td>
            <td>${cancha.nombre}</td>
            <td>${cancha.tipo}</td>
            <td>${cancha.superficie}</td>
            <td>${cancha.capacidad}</td>

            <td>
                ₡${Number(cancha.tarifa)
                    .toLocaleString("es-CR")}
            </td>

            <td>${cancha.estado}</td>

            <td>

                <button
                    type="button"
                    onclick="editarCancha(${cancha.id})"
                >
                    Editar
                </button>

                <button
                    type="button"
                    class="boton-eliminar"
                    onclick="eliminarCancha(${cancha.id})"
                >
                    Eliminar
                </button>

            </td>
        `;

        tablaCanchas.appendChild(fila);
    });
}


/* =========================================================
   DATOS DEL FORMULARIO
========================================================= */

function obtenerDatosFormulario() {

    return {

        nombre:
            document
                .getElementById("nombreCancha")
                .value
                .trim(),

        tipo:
            document
                .getElementById("tipo")
                .value,

        superficie:
            document
                .getElementById("superficie")
                .value,

        capacidad:
            Number(
                document
                    .getElementById("capacidad")
                    .value
            ),

        tarifa:
            Number(
                document
                    .getElementById("tarifa")
                    .value
            ),

        estado:
            document
                .getElementById("estado")
                .value
    };
}


/* =========================================================
   VALIDACIONES
========================================================= */

function validarCancha(cancha) {

    if (cancha.nombre === "") {

        mostrarMensaje(
            "Debe ingresar el nombre.",
            "error"
        );

        return false;
    }

    if (cancha.tipo === "") {

        mostrarMensaje(
            "Debe seleccionar el tipo.",
            "error"
        );

        return false;
    }

    if (cancha.superficie === "") {

        mostrarMensaje(
            "Debe seleccionar la superficie.",
            "error"
        );

        return false;
    }

    if (cancha.capacidad <= 0) {

        mostrarMensaje(
            "La capacidad debe ser mayor a cero.",
            "error"
        );

        return false;
    }

    if (cancha.tarifa <= 0) {

        mostrarMensaje(
            "La tarifa debe ser mayor a cero.",
            "error"
        );

        return false;
    }

    return true;
}


/* =========================================================
   CREAR
========================================================= */

async function registrarCancha(datosCancha) {

    try {

        const respuesta = await fetch(
            "../backend/canchas/crear.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify(datosCancha)
            }
        );

        const datos =
            await respuesta.json();

        if (!datos.exito) {
            throw new Error(datos.mensaje);
        }

        limpiarFormularioCancha();

        await cargarCanchas();

        mostrarMensaje(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        mostrarMensaje(
            error.message,
            "error"
        );
    }
}


/* =========================================================
   ACTUALIZAR
========================================================= */

async function actualizarCancha(
    id,
    datosCancha
) {

    try {

        const respuesta = await fetch(
            "../backend/canchas/actualizar.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body: JSON.stringify({
                    id: id,
                    ...datosCancha
                })
            }
        );

        const datos =
            await respuesta.json();

        if (!datos.exito) {
            throw new Error(datos.mensaje);
        }

        limpiarFormularioCancha();

        await cargarCanchas();

        mostrarMensaje(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        mostrarMensaje(
            error.message,
            "error"
        );
    }
}


/* =========================================================
   EDITAR
========================================================= */

function editarCancha(id) {

    const cancha = canchas.find(
        function (item) {
            return item.id === id;
        }
    );

    if (!cancha) {
        return;
    }

    document.getElementById(
        "idCancha"
    ).value = cancha.id;

    document.getElementById(
        "nombreCancha"
    ).value = cancha.nombre;

    document.getElementById(
        "tipo"
    ).value = cancha.tipo;

    document.getElementById(
        "superficie"
    ).value = cancha.superficie;

    document.getElementById(
        "capacidad"
    ).value = cancha.capacidad;

    document.getElementById(
        "tarifa"
    ).value = cancha.tarifa;

    document.getElementById(
        "estado"
    ).value = cancha.estado;

    tituloFormulario.textContent =
        "Editar cancha";

    btnGuardarCancha.textContent =
        "Actualizar cancha";

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}


/* =========================================================
   ELIMINAR
========================================================= */

async function eliminarCancha(id) {

    const cancha = canchas.find(
        function (item) {
            return item.id === id;
        }
    );

    if (!cancha) {
        return;
    }

    const confirmar = confirm(
        `¿Desea eliminar la cancha "${cancha.nombre}"?`
    );

    if (!confirmar) {
        return;
    }

    try {

        const respuesta = await fetch(
            "../backend/canchas/eliminar.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body: JSON.stringify({
                    id: id
                })
            }
        );

        const datos =
            await respuesta.json();

        if (!datos.exito) {
            throw new Error(datos.mensaje);
        }

        limpiarFormularioCancha();

        await cargarCanchas();

        mostrarMensaje(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        mostrarMensaje(
            error.message,
            "error"
        );
    }
}


/* =========================================================
   SUBMIT
========================================================= */

formularioCancha.addEventListener(
    "submit",
    async function (evento) {

        evento.preventDefault();

        const idCancha =
            document
                .getElementById("idCancha")
                .value;

        const datosCancha =
            obtenerDatosFormulario();

        if (!validarCancha(datosCancha)) {
            return;
        }

        if (idCancha === "") {

            await registrarCancha(
                datosCancha
            );

        } else {

            await actualizarCancha(
                Number(idCancha),
                datosCancha
            );
        }
    }
);


/* =========================================================
   LIMPIAR
========================================================= */

function limpiarFormularioCancha() {

    formularioCancha.reset();

    document.getElementById(
        "idCancha"
    ).value = "";

    document.getElementById(
        "estado"
    ).value = "ACTIVA";

    tituloFormulario.textContent =
        "Registrar cancha";

    btnGuardarCancha.textContent =
        "Guardar cancha";
}


/* =========================================================
   MENSAJES
========================================================= */

function mostrarMensaje(
    texto,
    tipo
) {

    mensajeCancha.textContent =
        texto;

    mensajeCancha.className =
        tipo;
}


/* =========================================================
   CANCELAR
========================================================= */

btnCancelarCancha.addEventListener(
    "click",
    function () {

        limpiarFormularioCancha();

        mensajeCancha.textContent = "";
        mensajeCancha.className = "";
    }
);


/* =========================================================
   INICIO
========================================================= */

cargarCanchas();