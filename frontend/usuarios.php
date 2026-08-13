<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Usuarios | FieldBook Pro</title><link rel="stylesheet" href="css/estilos.css">
</head><body>
<header class="encabezado"><div class="contenedor"><h1>FieldBook Pro</h1><p>Gestión de usuarios</p></div></header>
<main class="contenedor"><a href="index.php" class="boton-volver">Volver al inicio</a>
<section class="panel"><h2 id="tituloUsuario">Registrar usuario</h2>
<form id="formUsuario"><input type="hidden" id="idUsuario">
<div class="campo"><label>Nombre</label><input id="nombreUsuario" required></div>
<div class="campo"><label>Apellidos</label><input id="apellidosUsuario" required></div>
<div class="campo"><label>Correo</label><input type="email" id="correoUsuario" required></div>
<div class="campo"><label>Contraseña</label><input type="password" id="contrasenaUsuario"></div>
<div class="campo"><label>Rol</label><select id="rolUsuario"><option>ADMINISTRADOR</option><option>RECEPCIONISTA</option></select></div>
<div class="campo"><label>Estado</label><select id="estadoUsuario"><option>ACTIVO</option><option>INACTIVO</option></select></div>
<button type="submit" id="btnGuardarUsuario">Guardar usuario</button>
<button type="button" id="btnCancelarUsuario" class="boton-secundario">Cancelar</button>
</form><p id="mensajeUsuario"></p></section>
<section class="panel"><h2>Usuarios registrados</h2><div class="tabla-contenedor"><table>
<thead><tr><th>ID</th><th>Nombre</th><th>Apellidos</th><th>Correo</th><th>Rol</th><th>Estado</th><th>Acciones</th></tr></thead>
<tbody id="tablaUsuarios"></tbody></table></div></section>
</main><script src="js/usuarios.js"></script></body></html>