<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Editar Cargo</title>
	<link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
	<h1>Editar Cargo</h1>
	<form method="POST">
		<label for="NombreCargo">Nombre del cargo:</label>
		<input type="text" id="NombreCargo" name="NombreCargo" maxlength="30" value="<?= htmlspecialchars($cargo->NombreCargo, ENT_QUOTES, 'UTF-8') ?>" required>

		<button type="submit">Actualizar</button>
	</form>
</body>
</html>
