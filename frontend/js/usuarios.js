const form=document.getElementById("formUsuario"),tabla=document.getElementById("tablaUsuarios"),mensaje=document.getElementById("mensajeUsuario");
let usuarios=[];
async function cargar(){try{const r=await fetch("../backend/usuarios/listar.php");const d=await r.json();if(!d.exito)throw new Error(d.mensaje);usuarios=d.usuarios;mostrar();}catch(e){mensaje.textContent=e.message;}}
function mostrar(){tabla.innerHTML="";usuarios.forEach(u=>{const tr=document.createElement("tr");tr.innerHTML=`<td>${u.id}</td><td>${u.nombre}</td><td>${u.apellidos}</td><td>${u.correo}</td><td>${u.rol}</td><td>${u.estado}</td><td><button onclick="editarUsuario(${u.id})">Editar</button> <button class="boton-eliminar" onclick="eliminarUsuario(${u.id})">Eliminar</button></td>`;tabla.appendChild(tr);});}
form.addEventListener("submit",async e=>{
 e.preventDefault();const id=idUsuario.value;
 const datos={nombre:nombreUsuario.value.trim(),apellidos:apellidosUsuario.value.trim(),correo:correoUsuario.value.trim(),rol:rolUsuario.value,estado:estadoUsuario.value};
 let url;
 if(id===""){datos.contrasena=contrasenaUsuario.value;url="../backend/usuarios/crear.php";}else{datos.id=Number(id);url="../backend/usuarios/actualizar.php";}
 try{const r=await fetch(url,{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify(datos)});const d=await r.json();if(!d.exito)throw new Error(d.mensaje);limpiar();await cargar();mensaje.textContent=d.mensaje;}catch(err){mensaje.textContent=err.message;}
});
function editarUsuario(id){const u=usuarios.find(x=>x.id===id);if(!u)return;idUsuario.value=u.id;nombreUsuario.value=u.nombre;apellidosUsuario.value=u.apellidos;correoUsuario.value=u.correo;rolUsuario.value=u.rol;estadoUsuario.value=u.estado;contrasenaUsuario.value="";document.getElementById("tituloUsuario").textContent="Editar usuario";document.getElementById("btnGuardarUsuario").textContent="Actualizar usuario";}
async function eliminarUsuario(id){if(!confirm("¿Desea eliminar este usuario?"))return;try{const r=await fetch("../backend/usuarios/eliminar.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({id})});const d=await r.json();if(!d.exito)throw new Error(d.mensaje);await cargar();mensaje.textContent=d.mensaje;}catch(e){mensaje.textContent=e.message;}}
function limpiar(){form.reset();idUsuario.value="";estadoUsuario.value="ACTIVO";document.getElementById("tituloUsuario").textContent="Registrar usuario";document.getElementById("btnGuardarUsuario").textContent="Guardar usuario";}
document.getElementById("btnCancelarUsuario").addEventListener("click",limpiar);cargar();