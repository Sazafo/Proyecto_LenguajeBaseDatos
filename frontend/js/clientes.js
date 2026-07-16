const formulario = document.getElementById("formCliente");
const tabla = document.getElementById("tablaClientes");
const mensaje = document.getElementById("mensaje");
const botonCancelar = document.getElementById("btnCancelar");

let clientes = [
    {
        id: 1,
        cedula: "118880999",
        nombre: "Santiago",
        apellidos: "Zamora Fonseca",
        correo: "santiago@email.com",
        telefono: "88889999"
    },
    {
        id: 2,
        cedula: "207770888",
        nombre: "Brenda",
        apellidos: "Pérez León",
        correo: "brenda@email.com",
        telefono: "87778888"
    }
];

function mostrarClientes() {
    tabla.innerHTML = "";

    clientes.forEach(function (cliente) {
        const fila = document.createElement("tr");

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
                    onclick="eliminarCliente(${cliente.id})"
                    class="boton-eliminar"
                >
                    Eliminar
                </button>
            </td>
        `;

        tabla.appendChild(fila);
    });
}

formulario.addEventListener("submit", function (evento) {
    evento.preventDefault();

    const idCliente = document.getElementById("idCliente").value;

    const cliente = {
        cedula: document.getElementById("cedula").value,
        nombre: document.getElementById("nombre").value,
        apellidos: document.getElementById("apellidos").value,
        correo: document.getElementById("correo").value,
        telefono: document.getElementById("telefono").value
    };

    if (idCliente === "") {
        cliente.id = clientes.length + 1;
        clientes.push(cliente);

        mensaje.textContent = "Cliente registrado correctamente";
    } else {
        const posicion = clientes.findIndex(function (item) {
            return item.id === Number(idCliente);
        });

        clientes[posicion] = {
            id: Number(idCliente),
            ...cliente
        };

        mensaje.textContent = "Cliente actualizado correctamente";
    }

    limpiarFormulario();
    mostrarClientes();
});

function editarCliente(id) {
    const cliente = clientes.find(function (item) {
        return item.id === id;
    });

    document.getElementById("idCliente").value = cliente.id;
    document.getElementById("cedula").value = cliente.cedula;
    document.getElementById("nombre").value = cliente.nombre;
    document.getElementById("apellidos").value = cliente.apellidos;
    document.getElementById("correo").value = cliente.correo;
    document.getElementById("telefono").value = cliente.telefono;
}

function eliminarCliente(id) {
    const confirmar = confirm(
        "¿Desea eliminar este cliente?"
    );

    if (!confirmar) {
        return;
    }

    clientes = clientes.filter(function (cliente) {
        return cliente.id !== id;
    });

    mensaje.textContent = "Cliente eliminado correctamente";

    mostrarClientes();
}

function limpiarFormulario() {
    formulario.reset();
    document.getElementById("idCliente").value = "";
}

botonCancelar.addEventListener("click", function () {
    limpiarFormulario();
    mensaje.textContent = "";
});

mostrarClientes();