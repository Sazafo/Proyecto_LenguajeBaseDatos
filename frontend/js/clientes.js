const form=document.getElementById("formCliente"), tabla=document.getElementById("tablaClientes"), mensaje=document.getElementById("mensajeCliente");
let clientes=[];

async function cargarClientes(){
 try{const r=await fetch("../backend/clientes/listar.php");const d=await r.json();if(!d.exito)throw new Error(d.mensaje);clientes=d.clientes;mostrar();}
 catch(e){mensaje.textContent=e.message;}
}
function mostrar(){
 tabla.innerHTML="";
 clientes.forEach(c=>{
  const tr=document.createElement("tr");
  tr.innerHTML=`<td>${c.id}</td><td>${c.cedula}</td><td>${c.nombre}</td><td>${c.apellidos}</td><td>${c.correo}</td><td>${c.telefono}</td>
  <td><button onclick="editarCliente(${c.id})">Editar</button> <button class="boton-eliminar" onclick="eliminarCliente(${c.id})">Eliminar</button></td>`;
  tabla.appendChild(tr);
 });
}
form.addEventListener("submit",async e=>{
 e.preventDefault();
 const id=document.getElementById("idCliente").value;
 const datos={cedula:cedula.value.trim(),nombre:nombre.value.trim(),apellidos:apellidos.value.trim(),correo:correo.value.trim(),telefono:telefono.value.trim()};
 const url=id===""?"../backend/clientes/crear.php":"../backend/clientes/actualizar.php";
 if(id!=="")datos.id=Number(id);
 try{const r=await fetch(url,{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(datos)});const d=await r.json();if(!d.exito)throw new Error(d.mensaje);limpiar();await cargarClientes();mensaje.textContent=d.mensaje;}
 catch(err){mensaje.textContent=err.message;}
});
function editarCliente(id){
 const c=clientes.find(x=>x.id===id); if(!c)return;
 idCliente.value=c.id;cedula.value=c.cedula;nombre.value=c.nombre;apellidos.value=c.apellidos;correo.value=c.correo;telefono.value=c.telefono;
 document.getElementById("tituloCliente").textContent="Editar cliente";document.getElementById("btnGuardarCliente").textContent="Actualizar cliente";
}
async function eliminarCliente(id){
 if(!confirm("¿Desea eliminar este cliente?"))return;
 try{const r=await fetch("../backend/clientes/eliminar.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({id})});const d=await r.json();if(!d.exito)throw new Error(d.mensaje);await cargarClientes();mensaje.textContent=d.mensaje;}
 catch(e){mensaje.textContent=e.message;}
}
function limpiar(){form.reset();idCliente.value="";document.getElementById("tituloCliente").textContent="Registrar cliente";document.getElementById("btnGuardarCliente").textContent="Guardar cliente";}
document.getElementById("btnCancelarCliente").addEventListener("click",limpiar);
cargarClientes();