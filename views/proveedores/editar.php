<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Editar Proveedor</title>
	<link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
	<h1>Editar Proveedor</h1>
	<form method="POST">
		<label for="Nombre">Nombre:</label>
		<input type="text" id="Nombre" name="Nombre" maxlength="100" value="<?= htmlspecialchars($proveedor->Nombre, ENT_QUOTES, 'UTF-8') ?>" required>

		<label for="Telefono">Telefono:</label>
		<input type="text" id="Telefono" name="Telefono" maxlength="12" value="<?= htmlspecialchars($proveedor->Telefono, ENT_QUOTES, 'UTF-8') ?>" required>

		<label for="Correo">Correo:</label>
		<input type="email" id="Correo" name="Correo" maxlength="60" value="<?= htmlspecialchars($proveedor->Correo ?? '', ENT_QUOTES, 'UTF-8') ?>">

		<label for="Direccion">Direccion:</label>
		<input type="text" id="Direccion" name="Direccion" maxlength="150" value="<?= htmlspecialchars($proveedor->Direccion ?? '', ENT_QUOTES, 'UTF-8') ?>">

		<button type="submit">Actualizar</button>
	</form>
</body>
</html>
