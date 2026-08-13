const resumenReservas =
    document.getElementById(
        "resumenReservas"
    );

const resumenPagos =
    document.getElementById(
        "resumenPagos"
    );

const resumenCanchas =
    document.getElementById(
        "resumenCanchas"
    );


async function cargarResumen() {

    try {

        const respuesta = await fetch(
            "../backend/dashboard/resumen.php"
        );

        const datos =
            await respuesta.json();

        if (
            !respuesta.ok ||
            !datos.exito
        ) {

            throw new Error(
                datos.mensaje ||
                "No se pudo cargar el resumen."
            );
        }


        resumenReservas.textContent =
            datos.resumen.reservas_hoy;


        resumenPagos.textContent =
            datos.resumen.pagos_pendientes;


        resumenCanchas.textContent =
            datos.resumen.canchas_disponibles;


    } catch (error) {

        console.error(
            "Error al cargar resumen:",
            error
        );


        resumenReservas.textContent =
            "-";

        resumenPagos.textContent =
            "-";

        resumenCanchas.textContent =
            "-";
    }
}


cargarResumen();