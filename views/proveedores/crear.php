<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Nuevo Proveedor</title>
	<link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
	<h1>Nuevo Proveedor</h1>
	<form method="POST">
		<label for="Nombre">Nombre:</label>
		<input type="text" id="Nombre" name="Nombre" maxlength="100" required>

		<label for="Telefono">Telefono:</label>
		<input type="text" id="Telefono" name="Telefono" maxlength="12" required>

		<label for="Correo">Correo:</label>
		<input type="email" id="Correo" name="Correo" maxlength="60">

		<label for="Direccion">Direccion:</label>
		<input type="text" id="Direccion" name="Direccion" maxlength="150">

		<button type="submit">Guardar</button>
	</form>
</body>
</html>
