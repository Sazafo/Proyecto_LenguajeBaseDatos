const formularioPago =
    document.getElementById("formPago");

const tablaPagos =
    document.getElementById("tablaPagos");

const mensajePago =
    document.getElementById("mensajePago");

const btnCancelarPago =
    document.getElementById("btnCancelarPago");

const btnGuardarPago =
    document.getElementById("btnGuardarPago");

const tituloPago =
    document.getElementById("tituloPago");

const reservaPago =
    document.getElementById("reservaPago");

const montoPago =
    document.getElementById("montoPago");

const metodoPago =
    document.getElementById("metodoPago");

const estadoPago =
    document.getElementById("estadoPago");

let pagos = [];


/* =====================================================
   CARGAR RESERVAS
===================================================== */

async function cargarOpcionesPago() {

    try {

        const respuesta = await fetch(
            "../backend/pagos/opciones.php"
        );

        const datos = await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudieron cargar las reservas."
            );
        }

        reservaPago.innerHTML = `
            <option value="">
                Seleccione una reserva
            </option>
        `;

        datos.reservas.forEach(
            function (reserva) {

                const opcion =
                    document.createElement("option");

                opcion.value =
                    reserva.id;

                opcion.textContent =
                    reserva.descripcion;

                reservaPago.appendChild(
                    opcion
                );
            }
        );

    } catch (error) {

        console.error(
            "Error al cargar reservas:",
            error
        );

        mostrarMensajePago(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   LISTAR PAGOS
===================================================== */

async function cargarPagos() {

    try {

        const respuesta = await fetch(
            "../backend/pagos/listar.php"
        );

        const datos = await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudieron cargar los pagos."
            );
        }

        pagos = datos.pagos;

        mostrarPagos();

    } catch (error) {

        console.error(
            "Error al cargar pagos:",
            error
        );

        mostrarMensajePago(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   MOSTRAR PAGOS
===================================================== */

function mostrarPagos() {

    tablaPagos.innerHTML = "";

    if (pagos.length === 0) {

        tablaPagos.innerHTML = `
            <tr>
                <td colspan="7">
                    No existen pagos registrados.
                </td>
            </tr>
        `;

        return;
    }

    pagos.forEach(
        function (pago) {

            const fila =
                document.createElement("tr");

            fila.innerHTML = `
                <td>${pago.id}</td>

                <td>
                    ${pago.id_reserva}
                </td>

                <td>
                    ₡${Number(pago.monto)
                        .toLocaleString("es-CR")}
                </td>

                <td>
                    ${pago.metodo}
                </td>

                <td>
                    ${pago.fecha}
                </td>

                <td>
                    ${pago.estado}
                </td>

                <td>

                    <button
                        type="button"
                        onclick="editarPago(${pago.id})"
                    >
                        Editar
                    </button>

                    <button
                        type="button"
                        class="boton-eliminar"
                        onclick="eliminarPago(${pago.id})"
                    >
                        Eliminar
                    </button>

                </td>
            `;

            tablaPagos.appendChild(
                fila
            );
        }
    );
}


/* =====================================================
   OBTENER DATOS
===================================================== */

function obtenerDatosPago() {

    return {

        id_reserva:
            Number(
                reservaPago.value
            ),

        monto:
            Number(
                montoPago.value
            ),

        metodo:
            metodoPago.value,

        estado:
            estadoPago.value
    };
}


/* =====================================================
   VALIDAR
===================================================== */

function validarPago(pago) {

    if (!pago.id_reserva) {

        mostrarMensajePago(
            "Debe seleccionar una reserva.",
            "error"
        );

        return false;
    }

    if (
        !pago.monto ||
        pago.monto <= 0
    ) {

        mostrarMensajePago(
            "El monto debe ser mayor a cero.",
            "error"
        );

        return false;
    }

    if (pago.metodo === "") {

        mostrarMensajePago(
            "Debe seleccionar el método de pago.",
            "error"
        );

        return false;
    }

    if (pago.estado === "") {

        mostrarMensajePago(
            "Debe seleccionar el estado.",
            "error"
        );

        return false;
    }

    return true;
}


/* =====================================================
   CREAR PAGO
===================================================== */

async function registrarPago(
    datosPago
) {

    try {

        const respuesta = await fetch(
            "../backend/pagos/crear.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify(
                        datosPago
                    )
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo registrar el pago."
            );
        }

        limpiarFormularioPago();

        await cargarPagos();

        mostrarMensajePago(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al registrar pago:",
            error
        );

        mostrarMensajePago(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   ACTUALIZAR PAGO
===================================================== */

async function actualizarPago(
    id,
    datosPago
) {

    try {

        const respuesta = await fetch(
            "../backend/pagos/actualizar.php",
            {
                method: "POST",

                headers: {
                    "Content-Type":
                        "application/json"
                },

                body:
                    JSON.stringify({
                        id: id,
                        ...datosPago
                    })
            }
        );

        const datos =
            await respuesta.json();

        if (!respuesta.ok || !datos.exito) {

            throw new Error(
                datos.mensaje ||
                "No se pudo actualizar el pago."
            );
        }

        limpiarFormularioPago();

        await cargarPagos();

        mostrarMensajePago(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al actualizar pago:",
            error
        );

        mostrarMensajePago(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   SUBMIT
===================================================== */

formularioPago.addEventListener(
    "submit",
    async function (evento) {

        evento.preventDefault();

        const idPago =
            document
                .getElementById(
                    "idPago"
                )
                .value;

        const datosPago =
            obtenerDatosPago();

        if (
            !validarPago(
                datosPago
            )
        ) {
            return;
        }

        if (idPago === "") {

            await registrarPago(
                datosPago
            );

        } else {

            await actualizarPago(
                Number(idPago),
                datosPago
            );
        }
    }
);


/* =====================================================
   EDITAR
===================================================== */

function editarPago(id) {

    const pago =
        pagos.find(
            function (item) {
                return item.id === id;
            }
        );

    if (!pago) {
        return;
    }

    document.getElementById(
        "idPago"
    ).value = pago.id;

    reservaPago.value =
        pago.id_reserva;

    montoPago.value =
        pago.monto;

    metodoPago.value =
        pago.metodo;

    estadoPago.value =
        pago.estado;

    tituloPago.textContent =
        "Editar pago";

    btnGuardarPago.textContent =
        "Actualizar pago";

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}


/* =====================================================
   ELIMINAR
===================================================== */

async function eliminarPago(id) {

    const pago =
        pagos.find(
            function (item) {
                return item.id === id;
            }
        );

    if (!pago) {
        return;
    }

    const confirmar = confirm(
        `¿Desea eliminar el pago #${pago.id}?`
    );

    if (!confirmar) {
        return;
    }

    try {

        const respuesta = await fetch(
            "../backend/pagos/eliminar.php",
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
                "No se pudo eliminar el pago."
            );
        }

        await cargarPagos();

        mostrarMensajePago(
            datos.mensaje,
            "exito"
        );

    } catch (error) {

        console.error(
            "Error al eliminar pago:",
            error
        );

        mostrarMensajePago(
            error.message,
            "error"
        );
    }
}


/* =====================================================
   LIMPIAR
===================================================== */

function limpiarFormularioPago() {

    formularioPago.reset();

    document.getElementById(
        "idPago"
    ).value = "";

    estadoPago.value =
        "PENDIENTE";

    metodoPago.value =
        "EFECTIVO";

    tituloPago.textContent =
        "Registrar pago";

    btnGuardarPago.textContent =
        "Guardar pago";
}


/* =====================================================
   MENSAJES
===================================================== */

function mostrarMensajePago(
    texto,
    tipo
) {

    mensajePago.textContent =
        texto;

    mensajePago.className =
        tipo;
}


/* =====================================================
   CANCELAR
===================================================== */

btnCancelarPago.addEventListener(
    "click",
    function () {

        limpiarFormularioPago();

        mensajePago.textContent =
            "";

        mensajePago.className =
            "";
    }
);


/* =====================================================
   INICIO
===================================================== */

cargarOpcionesPago();

cargarPagos();