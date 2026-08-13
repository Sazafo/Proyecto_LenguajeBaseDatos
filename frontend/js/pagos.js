const form = document.getElementById("formPago");
const tabla = document.getElementById("tablaPagos");
const mensaje = document.getElementById("mensajePago");

let pagos = [];

// Cargar opciones de reservas
async function opciones() {
    const r = await fetch("../backend/pagos/opciones.php");
    const d = await r.json();

    reservaPago.innerHTML = '<option value="">Seleccione</option>';

    d.reservas.forEach(x => {
        reservaPago.innerHTML += `
            <option value="${x.id}">
                ${x.descripcion}
            </option>
        `;
    });
}

// Cargar pagos
async function cargar() {
    try {
        const r = await fetch("../backend/pagos/listar.php");
        const d = await r.json();

        if (!d.exito) {
            throw new Error(d.mensaje);
        }

        pagos = d.pagos;
        mostrar();

    } catch (e) {
        mensaje.textContent = e.message;
    }
}

// Mostrar pagos en la tabla
function mostrar() {
    tabla.innerHTML = "";

    pagos.forEach(x => {

        const tr = document.createElement("tr");

        tr.innerHTML = `
            <td>${x.id}</td>
            <td>${x.id_reserva}</td>
            <td>₡${Number(x.monto).toLocaleString("es-CR")}</td>
            <td>${x.metodo}</td>
            <td>${x.fecha}</td>
            <td>${x.estado}</td>
            <td>
                <button onclick="editarPago(${x.id})">
                    Editar
                </button>

                <button 
                    class="boton-eliminar" 
                    onclick="eliminarPago(${x.id})">
                    Eliminar
                </button>
            </td>
        `;

        tabla.appendChild(tr);
    });
}

// Registrar o actualizar pago
form.addEventListener("submit", async e => {

    e.preventDefault();

    const id = idPago.value;

    const datos = {
        id_reserva: Number(reservaPago.value),
        monto: Number(montoPago.value),
        metodo: metodoPago.value,
        estado: estadoPago.value
    };

    let url = "../backend/pagos/crear.php";

    // Si existe un ID, se actualiza el pago
    if (id !== "") {

        datos.id = Number(id);
        url = "../backend/pagos/actualizar.php";
    }

    try {

        const r = await fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(datos)
        });

        const d = await r.json();

        if (!d.exito) {
            throw new Error(d.mensaje);
        }

        limpiar();

        await cargar();

        mensaje.textContent = d.mensaje;

    } catch (err) {

        mensaje.textContent = err.message;
    }
});

// Editar pago
function editarPago(id) {

    const x = pagos.find(p => p.id === id);

    if (!x) {
        return;
    }

    idPago.value = x.id;
    reservaPago.value = x.id_reserva;
    montoPago.value = x.monto;
    metodoPago.value = x.metodo;
    estadoPago.value = x.estado;

    document.getElementById("tituloPago").textContent = "Editar pago";
    document.getElementById("btnGuardarPago").textContent = "Actualizar pago";
}

// Eliminar pago
async function eliminarPago(id) {

    if (!confirm("¿Desea eliminar este pago?")) {
        return;
    }

    try {

        const r = await fetch("../backend/pagos/eliminar.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                id: id
            })
        });

        const d = await r.json();

        if (!d.exito) {
            throw new Error(d.mensaje);
        }

        await cargar();

        mensaje.textContent = d.mensaje;

    } catch (e) {

        mensaje.textContent = e.message;
    }
}

// Limpiar formulario
function limpiar() {

    form.reset();

    idPago.value = "";
    estadoPago.value = "PENDIENTE";

    document.getElementById("tituloPago").textContent = "Registrar pago";
    document.getElementById("btnGuardarPago").textContent = "Guardar pago";
}

// Botón cancelar
document
    .getElementById("btnCancelarPago")
    .addEventListener("click", limpiar);

// Inicializar
opciones();
cargar();