const formularioDisponibilidad =
    document.getElementById(
        "formDisponibilidad"
    );

const fechaInicioDisponibilidad =
    document.getElementById(
        "fechaInicioDisponibilidad"
    );

const fechaFinDisponibilidad =
    document.getElementById(
        "fechaFinDisponibilidad"
    );

const listaDisponibilidad =
    document.getElementById(
        "listaDisponibilidad"
    );

const mensajeDisponibilidad =
    document.getElementById(
        "mensajeDisponibilidad"
    );

const btnLimpiarDisponibilidad =
    document.getElementById(
        "btnLimpiarDisponibilidad"
    );


/* =====================================================
   CONSULTAR DISPONIBILIDAD
===================================================== */

async function consultarDisponibilidad() {

    const fechaInicio =
        fechaInicioDisponibilidad.value;

    const fechaFin =
        fechaFinDisponibilidad.value;


    if (
        fechaInicio === "" ||
        fechaFin === ""
    ) {

        mostrarMensajeDisponibilidad(
            "Debe seleccionar fecha y hora de inicio y fin.",
            "error"
        );

        return;
    }


    const inicio =
        new Date(
            fechaInicio
        );

    const fin =
        new Date(
            fechaFin
        );


    if (fin <= inicio) {

        mostrarMensajeDisponibilidad(
            "La fecha final debe ser posterior a la inicial.",
            "error"
        );

        return;
    }


    try {

        const respuesta = await fetch(
            "../backend/disponibilidad/consultar.php",
            {

                method: "POST",

                headers: {

                    "Content-Type":
                        "application/json"

                },

                body:
                    JSON.stringify({

                        fecha_inicio:
                            fechaInicio,

                        fecha_fin:
                            fechaFin

                    })

            }
        );


        const datos =
            await respuesta.json();


        if (
            !respuesta.ok ||
            !datos.exito
        ) {

            throw new Error(
                datos.mensaje ||
                "No se pudo consultar la disponibilidad."
            );

        }


        mostrarCanchasDisponibles(
            datos.canchas
        );


        mostrarMensajeDisponibilidad(
            "Consulta realizada correctamente.",
            "exito"
        );


    } catch (error) {

        console.error(
            "Error de disponibilidad:",
            error
        );


        mostrarMensajeDisponibilidad(
            error.message,
            "error"
        );

    }
}


/* =====================================================
   MOSTRAR RESULTADOS
===================================================== */

function mostrarCanchasDisponibles(
    canchas
) {

    listaDisponibilidad.innerHTML =
        "";


    if (canchas.length === 0) {

        listaDisponibilidad.innerHTML = `
            <p>
                No existen canchas registradas.
            </p>
        `;

        return;
    }


    canchas.forEach(
        function (cancha) {

            const tarjeta =
                document.createElement(
                    "div"
                );


            let claseEstado =
                "estado-disponible";


            if (
                cancha.disponibilidad ===
                "RESERVADA"
            ) {

                claseEstado =
                    "estado-reservada";

            }


            if (
                cancha.disponibilidad ===
                "MANTENIMIENTO"
            ) {

                claseEstado =
                    "estado-mantenimiento";

            }


            if (
                cancha.disponibilidad ===
                "INACTIVA"
            ) {

                claseEstado =
                    "estado-inactiva";

            }


            tarjeta.className =
                "tarjeta-disponibilidad";


            tarjeta.innerHTML = `

                <div
                    class="cabecera-disponibilidad"
                >

                    <div>

                        <h3>
                            ${cancha.nombre}
                        </h3>

                        <p>
                            ${cancha.tipo}
                        </p>

                    </div>


                    <span
                        class="estado-cancha ${claseEstado}"
                    >
                        ${cancha.disponibilidad}
                    </span>

                </div>


                <div
                    class="detalle-disponibilidad"
                >

                    <p>
                        <strong>
                            Superficie:
                        </strong>

                        ${cancha.superficie}
                    </p>


                    <p>
                        <strong>
                            Capacidad:
                        </strong>

                        ${cancha.capacidad}
                        jugadores
                    </p>


                    <p>
                        <strong>
                            Tarifa:
                        </strong>

                        ₡${Number(
                            cancha.tarifa
                        ).toLocaleString(
                            "es-CR"
                        )}
                        / hora
                    </p>

                </div>

            `;


            listaDisponibilidad.appendChild(
                tarjeta
            );

        }
    );

}


/* =====================================================
   MENSAJES
===================================================== */

function mostrarMensajeDisponibilidad(
    texto,
    tipo
) {

    mensajeDisponibilidad.textContent =
        texto;

    mensajeDisponibilidad.className =
        tipo;

}


/* =====================================================
   FORMULARIO
===================================================== */

formularioDisponibilidad.addEventListener(
    "submit",
    async function (evento) {

        evento.preventDefault();

        await consultarDisponibilidad();

    }
);


/* =====================================================
   LIMPIAR
===================================================== */

btnLimpiarDisponibilidad.addEventListener(
    "click",
    function () {

        formularioDisponibilidad.reset();

        mensajeDisponibilidad.textContent =
            "";

        mensajeDisponibilidad.className =
            "";

        listaDisponibilidad.innerHTML = `

            <p class="texto-informativo">

                Seleccione un horario para
                consultar las canchas.

            </p>

        `;

    }
);