document.getElementById("formLogin").addEventListener("submit",async function(e){
 e.preventDefault();
 const mensaje=document.getElementById("mensajeLogin");
 try{
  const r=await fetch("../backend/usuarios/login.php",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({correo:document.getElementById("correoLogin").value.trim(),contrasena:document.getElementById("contrasenaLogin").value})});
  const d=await r.json();
  if(!d.exito)throw new Error(d.mensaje);
  mensaje.textContent=d.mensaje;
  window.location.href="index.php";
 }catch(err){mensaje.textContent=err.message;}
});