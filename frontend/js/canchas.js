const formularioCancha = document.getElementById("formCancha");
const tablaCanchas = document.getElementById("tablaCanchas");
const mensajeCancha = document.getElementById("mensajeCancha");
const btnCancelarCancha = document.getElementById(
    "btnCancelarCancha"
);

let canchas = [
    {
        id: 1,
        nombre: "Cancha Central",
        tipo: "Fútbol 5",
        superficie: "Césped sintético",
        capacidad: 10,
        tarifa: 25000,
        estado: "ACTIVA"
    },
    {
        id: 2,
        nombre: "Cancha Norte",
        tipo: "Fútbol 7",
        superficie: "Césped natural",
        capacidad: 14,
        tarifa: 35000,
        estado: "MANTENIMIENTO"
    }
];

function mostrarCanchas() {
    tablaCanchas.innerHTML = "";

    canchas.forEach(function (cancha) {
        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td>${cancha.id}</td>
            <td>${cancha.nombre}</td>
            <td>${cancha.tipo}</td>
            <td>${cancha.superficie}</td>
            <td>${cancha.capacidad}</td>
            <td>₡${Number(cancha.tarifa).toLocaleString()}</td>
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

formularioCancha.addEventListener("submit", function (evento) {
    evento.preventDefault();

    const idCancha = document.getElementById("idCancha").value;

    const datosCancha = {
        nombre: document.getElementById("nombreCancha").value,
        tipo: document.getElementById("tipo").value,
        superficie: document.getElementById("superficie").value,
        capacidad: Number(
            document.getElementById("capacidad").value
        ),
        tarifa: Number(
            document.getElementById("tarifa").value
        ),
        estado: document.getElementById("estado").value
    };

    if (idCancha === "") {
        datosCancha.id = obtenerNuevoId();

        canchas.push(datosCancha);

        mensajeCancha.textContent =
            "Cancha registrada correctamente";
    } else {
        const posicion = canchas.findIndex(function (cancha) {
            return cancha.id === Number(idCancha);
        });

        canchas[posicion] = {
            id: Number(idCancha),
            ...datosCancha
        };

        mensajeCancha.textContent =
            "Cancha actualizada correctamente";
    }

    limpiarFormularioCancha();
    mostrarCanchas();
});

function obtenerNuevoId() {
    if (canchas.length === 0) {
        return 1;
    }

    const ids = canchas.map(function (cancha) {
        return cancha.id;
    });

    return Math.max(...ids) + 1;
}

function editarCancha(id) {
    const cancha = canchas.find(function (item) {
        return item.id === id;
    });

    document.getElementById("idCancha").value = cancha.id;
    document.getElementById("nombreCancha").value = cancha.nombre;
    document.getElementById("tipo").value = cancha.tipo;
    document.getElementById("superficie").value =
        cancha.superficie;
    document.getElementById("capacidad").value =
        cancha.capacidad;
    document.getElementById("tarifa").value = cancha.tarifa;
    document.getElementById("estado").value = cancha.estado;

    window.scrollTo({
        top: 0,
        behavior: "smooth"
    });
}

function eliminarCancha(id) {
    const confirmar = confirm(
        "¿Desea eliminar esta cancha?"
    );

    if (!confirmar) {
        return;
    }

    canchas = canchas.filter(function (cancha) {
        return cancha.id !== id;
    });

    mensajeCancha.textContent =
        "Cancha eliminada correctamente";

    mostrarCanchas();
}

function limpiarFormularioCancha() {
    formularioCancha.reset();

    document.getElementById("idCancha").value = "";
    document.getElementById("estado").value = "ACTIVA";
}

btnCancelarCancha.addEventListener("click", function () {
    limpiarFormularioCancha();
    mensajeCancha.textContent = "";
});

mostrarCanchas();