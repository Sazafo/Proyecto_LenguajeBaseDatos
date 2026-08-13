<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clientes | FieldBook Pro</title>
<link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header class="encabezado"><div class="contenedor"><h1>FieldBook Pro</h1><p>Gestión de clientes</p></div></header>
<main class="contenedor">
<a href="index.php" class="boton-volver">Volver al inicio</a>
<section class="panel">
<h2 id="tituloCliente">Registrar cliente</h2>
<form id="formCliente">
<input type="hidden" id="idCliente">
<div class="campo"><label>Cédula</label><input id="cedula" required></div>
<div class="campo"><label>Nombre</label><input id="nombre" required></div>
<div class="campo"><label>Apellidos</label><input id="apellidos" required></div>
<div class="campo"><label>Correo</label><input type="email" id="correo" required></div>
<div class="campo"><label>Teléfono</label><input id="telefono" required></div>
<button type="submit" id="btnGuardarCliente">Guardar cliente</button>
<button type="button" id="btnCancelarCliente" class="boton-secundario">Cancelar</button>
</form>
<p id="mensajeCliente"></p>
</section>
<section class="panel">
<h2>Clientes registrados</h2>
<div class="tabla-contenedor"><table>
<thead><tr><th>ID</th><th>Cédula</th><th>Nombre</th><th>Apellidos</th><th>Correo</th><th>Teléfono</th><th>Acciones</th></tr></thead>
<tbody id="tablaClientes"></tbody>
</table></div>
</section>
</main>
<script src="js/clientes.js"></script>
</body>
</html>