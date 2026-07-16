const formularioReserva = document.getElementById("formReserva");
const tablaReservas = document.getElementById("tablaReservas");
const mensajeReserva = document.getElementById("mensajeReserva");
const btnCancelarReserva = document.getElementById(
    "btnCancelarReserva"
);

const clienteReserva = document.getElementById("clienteReserva");
const canchaReserva = document.getElementById("canchaReserva");
const fechaReserva = document.getElementById("fechaReserva");
const horaInicio = document.getElementById("horaInicio");
const horaFin = document.getElementById("horaFin");
const estadoReserva = document.getElementById("estadoReserva");
const totalReserva = document.getElementById("totalReserva");

let reservas = [
    {
        id: 1,
        idCliente: 1,
        cliente: "Santiago Zamora Fonseca",
        idCancha: 1,
        cancha: "Cancha Central",
        fecha: "2026-07-20",
        horaInicio: "18:00",
        horaFin: "20:00",
        total: 50000,
        estado: "CONFIRMADA"
    }
];

function mostrarReservas() {
    tablaReservas.innerHTML = "";

    reservas.forEach(function (reserva) {
        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td>${reserva.id}</td>
            <td>${reserva.cliente}</td>
            <td>${reserva.cancha}</td>
            <td>${formatearFecha(reserva.fecha)}</td>
            <td>
                ${reserva.horaInicio} - ${reserva.horaFin}
            </td>
            <td>
                ₡${Number(reserva.total).toLocaleString()}
            </td>
            <td>${reserva.estado}</td>

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
                    onclick="eliminarReserva(${reserva.id})"
                >
                    Eliminar
                </button>
            </td>
        `;

        tablaReservas.appendChild(fila);
    });
}

function calcularTotalReserva() {
    const opcionCancha =
        canchaReserva.options[canchaReserva.selectedIndex];

    const tarifa = Number(
        opcionCancha?.dataset.tarifa || 0
    );

    if (
        tarifa === 0 ||
        horaInicio.value === "" ||
        horaFin.value === ""
    ) {
        totalReserva.value = "";
        return 0;
    }

    const inicio = convertirHoraAMinutos(horaInicio.value);
    const fin = convertirHoraAMinutos(horaFin.value);

    if (fin <= inicio) {
        totalReserva.value = "";
        return 0;
    }

    const cantidadHoras = (fin - inicio) / 60;
    const total = tarifa * cantidadHoras;

    totalReserva.value =
        "₡" + Number(total).toLocaleString();

    return total;
}

function convertirHoraAMinutos(hora) {
    const partes = hora.split(":");
    const horas = Number(partes[0]);
    const minutos = Number(partes[1]);

    return horas * 60 + minutos;
}

function existeCruceHorario(
    idCancha,
    fecha,
    inicio,
    fin,
    idReservaActual
) {
    const inicioNuevo = convertirHoraAMinutos(inicio);
    const finNuevo = convertirHoraAMinutos(fin);

    return reservas.some(function (reserva) {
        if (reserva.id === idReservaActual) {
            return false;
        }

        if (
            reserva.idCancha !== idCancha ||
            reserva.fecha !== fecha ||
            reserva.estado === "CANCELADA"
        ) {
            return false;
        }

        const inicioExistente = convertirHoraAMinutos(
            reserva.horaInicio
        );

        const finExistente = convertirHoraAMinutos(
            reserva.horaFin
        );

        return (
            inicioNuevo < finExistente &&
            finNuevo > inicioExistente
        );
    });
}

formularioReserva.addEventListener("submit", function (evento) {
    evento.preventDefault();

    const idReserva = Number(
        document.getElementById("idReserva").value
    );

    const idCliente = Number(clienteReserva.value);
    const idCancha = Number(canchaReserva.value);

    const nombreCliente =
        clienteReserva.options[
            clienteReserva.selectedIndex
        ].text.trim();

    const nombreCancha =
        canchaReserva.options[
            canchaReserva.selectedIndex
        ].text.trim();

    const total = calcularTotalReserva();

    if (horaFin.value <= horaInicio.value) {
        mensajeReserva.textContent =
            "La hora de finalización debe ser mayor a la hora de inicio";
        return;
    }

    const cruce = existeCruceHorario(
        idCancha,
        fechaReserva.value,
        horaInicio.value,
        horaFin.value,
        idReserva
    );

    if (cruce) {
        mensajeReserva.textContent =
            "La cancha ya está reservada en ese horario";
        return;
    }

    const datosReserva = {
        idCliente: idCliente,
        cliente: nombreCliente,
        idCancha: idCancha,
        cancha: nombreCancha,
        fecha: fechaReserva.value,
        horaInicio: horaInicio.value,
        horaFin: horaFin.value,
        total: total,
        estado: estadoReserva.value
    };

    if (!idReserva) {
        datosReserva.id = obtenerNuevoIdReserva();
        reservas.push(datosReserva);

        mensajeReserva.textContent =
            "Reserva registrada correctamente";
    } else {
        const posicion = reservas.findIndex(function (reserva) {
            return reserva.id === idReserva;
        });

        reservas[posicion] = {
            id: idReserva,
            ...datosReserva
        };

        mensajeReserva.textContent =
            "Reserva actualizada correctamente";
    }

    limpiarFormularioReserva();
    mostrarReservas();
});

function obtenerNuevoIdReserva() {
    if (reservas.length === 0) {
        return 1;
    }

    const ids = reservas.map(function (reserva) {
        return reserva.id;
    });

    return Math.max(...ids) + 1;
}

function editarReserva(id) {
    const reserva = reservas.find(function (item) {
        return item.id === id;
    });

    document.getElementById("idReserva").value = reserva.id;
    clienteReserva.value = reserva.idCliente;
    canchaReserva.value = reserva.idCancha;
    fechaReserva.value = reserva.fecha;
    horaInicio.value = reserva.horaInicio;
    horaFin.value = reserva.horaFin;
    estadoReserva.value = reserva.estado;

    calcularTotalReserva();

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

function eliminarReserva(id) {
    const confirmar = confirm(
        "¿Desea eliminar esta reserva?"
    );

    if (!confirmar) {
        return;
    }

    reservas = reservas.filter(function (reserva) {
        return reserva.id !== id;
    });

    mensajeReserva.textContent =
        "Reserva eliminada correctamente";

    mostrarReservas();
}

function limpiarFormularioReserva() {
    formularioReserva.reset();

    document.getElementById("idReserva").value = "";
    totalReserva.value = "";
    estadoReserva.value = "PENDIENTE";
}

function formatearFecha(fecha) {
    const partes = fecha.split("-");

    return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

canchaReserva.addEventListener(
    "change",
    calcularTotalReserva
);

horaInicio.addEventListener(
    "change",
    calcularTotalReserva
);

horaFin.addEventListener(
    "change",
    calcularTotalReserva
);

btnCancelarReserva.addEventListener(
    "click",
    function () {
        limpiarFormularioReserva();
        mensajeReserva.textContent = "";
    }
);

mostrarReservas();