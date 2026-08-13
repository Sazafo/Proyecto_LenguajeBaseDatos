const formularioReserva =
    document.getElementById("formReserva");

const tablaReservas =
    document.getElementById("tablaReservas");

const mensajeReserva =
    document.getElementById("mensajeReserva");

const btnCancelarEdicion =
    document.getElementById("btnCancelarEdicion");

const btnGuardarReserva =
    document.getElementById("btnGuardarReserva");

const tituloReserva =
    document.getElementById("tituloReserva");

const clienteReserva =
    document.getElementById("clienteReserva");

const canchaReserva =
    document.getElementById("canchaReserva");

const inicioReserva =
    document.getElementById("inicioReserva");

const finReserva =
    document.getElementById("finReserva");

const estadoReserva =
    document.getElementById("estadoReserva");

let reservas = [];


/* =====================================================
   CARGAR CLIENTES Y CANCHAS
===================================================== */

async function cargarOpcionesReserva() {

    try {

        const respuesta = await fetch(
            "../backend/reservas/opciones.php"
        );

        const datos = await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudieron cargar las opciones."
            );
        }


        clienteReserva.innerHTML =
            `<option value="">
                Seleccione un cliente
            </option>`;


        datos.clientes.forEach(
            function (cliente) {

                const opcion =
                    document.createElement("option");

                opcion.value =
                    cliente.id;

                opcion.textContent =
                    cliente.nombre;

                clienteReserva.appendChild(
                    opcion
                );
            }
        );


        canchaReserva.innerHTML =
            `<option value="">
                Seleccione una cancha
            </option>`;


        datos.canchas.forEach(
            function (cancha) {

                const opcion =
                    document.createElement("option");

                opcion.value =
                    cancha.id;

                opcion.textContent =
                    `${cancha.nombre} (${cancha.estado})`;

                canchaReserva.appendChild(
                    opcion
                );
            }
        );

    } catch (error) {

        console.error(
            "Error al cargar opciones:",
            error
        );

        mostrarMensajeReserva(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   LISTAR RESERVAS
===================================================== */

async function cargarReservas() {

    try {

        const respuesta = await fetch(
            "../backend/reservas/listar.php"
        );

        const datos = await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudieron cargar las reservas."
            );
        }

        reservas = datos.reservas;

        mostrarReservas();

    } catch (error) {

        console.error(
            "Error al cargar reservas:",
            error
        );

        mostrarMensajeReserva(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   MOSTRAR RESERVAS
===================================================== */

function mostrarReservas() {

    tablaReservas.innerHTML = "";

    if (reservas.length === 0) {

        tablaReservas.innerHTML = `
            <tr>
                <td colspan="7">
                    No existen reservas registradas.
                </td>
            </tr>
        `;

        return;
    }

    reservas.forEach(
        function (reserva) {

            const fila =
                document.createElement("tr");

            fila.innerHTML = `
                <td>${reserva.id}</td>

                <td>${reserva.cliente}</td>

                <td>${reserva.cancha}</td>

                <td>
                    ${reserva.fecha_inicio}
                </td>

                <td>
                    ${reserva.fecha_fin}
                </td>

                <td>
                    ${reserva.estado}
                </td>

                <td>

                    <button
                        type="button"
                        onclick="editarReserva(${reserva.id})"
                    >
                        Editar
                    </button>

                    <button
                        type="button"
                        class="boton-eliminar"
                        onclick="cancelarReserva(${reserva.id})"
                    >
                        Cancelar
                    </button>

                </td>
            `;

            tablaReservas.appendChild(
                fila
            );
        }
    );
}


/* =====================================================
   OBTENER DATOS
===================================================== */

function obtenerDatosReserva() {

    return {

        id_cliente:
            Number(
                clienteReserva.value
            ),

        id_cancha:
            Number(
                canchaReserva.value
            ),

        fecha_inicio:
            inicioReserva.value,

        fecha_fin:
            finReserva.value,

        estado:
            estadoReserva.value
    };
}


/* =====================================================
   VALIDAR
===================================================== */

function validarReserva(reserva) {

    if (
        !reserva.id_cliente ||
        !reserva.id_cancha
    ) {

        mostrarMensajeReserva(
            "Debe seleccionar cliente y cancha.",
            "error"
        );

        return false;
    }

    if (
        reserva.fecha_inicio === "" ||
        reserva.fecha_fin === ""
    ) {

        mostrarMensajeReserva(
            "Debe seleccionar las fechas.",
            "error"
        );

        return false;
    }

    const inicio =
        new Date(
            reserva.fecha_inicio
        );

    const fin =
        new Date(
            reserva.fecha_fin
        );

    if (fin <= inicio) {

        mostrarMensajeReserva(
            "La fecha final debe ser posterior a la inicial.",
            "error"
        );

        return false;
    }

    return true;
}


/* =====================================================
   CREAR RESERVA
===================================================== */

async function registrarReserva(
    datosReserva
) {

    try {

        const respuesta = await fetch(
            "../backend/reservas/crear.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify(
                        datosReserva
                    )
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo registrar la reserva."
            );
        }

        limpiarFormularioReserva();

        await cargarReservas();

        mostrarMensajeReserva(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al registrar reserva:",
            error
        );

        mostrarMensajeReserva(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   ACTUALIZAR RESERVA
===================================================== */

async function actualizarReserva(
    id,
    datosReserva
) {

    try {

        const respuesta = await fetch(
            "../backend/reservas/actualizar.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify({
                        id: id,
                        ...datosReserva
                    })
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo actualizar la reserva."
            );
        }

        limpiarFormularioReserva();

        await cargarReservas();

        mostrarMensajeReserva(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al actualizar reserva:",
            error
        );

        mostrarMensajeReserva(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   SUBMIT
===================================================== */

formularioReserva.addEventListener(
    "submit",
    async function (evento) {

        evento.preventDefault();

        const idReserva =
            document
                .getElementById(
                    "idReserva"
                )
                .value;

        const datosReserva =
            obtenerDatosReserva();

        if (
            !validarReserva(
                datosReserva
            )
        ) {
            return;
        }

        if (idReserva === "") {

            await registrarReserva(
                datosReserva
            );

        } else {

            await actualizarReserva(
                Number(idReserva),
                datosReserva
            );
        }
    }
);


/* =====================================================
   EDITAR
===================================================== */

function editarReserva(id) {

    const reserva =
        reservas.find(
            function (item) {
                return item.id === id;
            }
        );

    if (!reserva) {
        return;
    }

    document.getElementById(
        "idReserva"
    ).value = reserva.id;

    clienteReserva.value =
        reserva.id_cliente;

    canchaReserva.value =
        reserva.id_cancha;

    inicioReserva.value =
        convertirFechaInput(
            reserva.fecha_inicio
        );

    finReserva.value =
        convertirFechaInput(
            reserva.fecha_fin
        );

    estadoReserva.value =
        reserva.estado;

    tituloReserva.textContent =
        "Editar reserva";

    btnGuardarReserva.textContent =
        "Actualizar reserva";

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}


/* =====================================================
   CONVERTIR FECHA PARA DATETIME-LOCAL
===================================================== */

function convertirFechaInput(fecha) {

    if (!fecha) {
        return "";
    }

    return fecha
        .replace(" ", "T")
        .substring(0, 16);
}


/* =====================================================
   CANCELAR RESERVA
===================================================== */

async function cancelarReserva(id) {

    const reserva =
        reservas.find(
            function (item) {
                return item.id === id;
            }
        );

    if (!reserva) {
        return;
    }

    const confirmar = confirm(
        `¿Desea cancelar la reserva #${reserva.id}?`
    );

    if (!confirmar) {
        return;
    }

    try {

        const respuesta = await fetch(
            "../backend/reservas/cancelar.php",
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
                "No se pudo cancelar la reserva."
            );
        }

        await cargarReservas();

        mostrarMensajeReserva(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al cancelar reserva:",
            error
        );

        mostrarMensajeReserva(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   LIMPIAR
===================================================== */

function limpiarFormularioReserva() {

    formularioReserva.reset();

    document.getElementById(
        "idReserva"
    ).value = "";

    estadoReserva.value =
        "PENDIENTE";

    tituloReserva.textContent =
        "Registrar reserva";

    btnGuardarReserva.textContent =
        "Guardar reserva";
}


/* =====================================================
   MENSAJES
===================================================== */

function mostrarMensajeReserva(
    texto,
    tipo
) {

    mensajeReserva.textContent =
        texto;

    mensajeReserva.className =
        tipo;
}


/* =====================================================
   CANCELAR EDICIÓN
===================================================== */

btnCancelarEdicion.addEventListener(
    "click",
    function () {

        limpiarFormularioReserva();

        mensajeReserva.textContent =
            "";

        mensajeReserva.className =
            "";
    }
);


/* =====================================================
   INICIO
===================================================== */

cargarOpcionesReserva();

cargarReservas();