<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Editar Categoria</title>
	<link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
	<h1 style="text-align: center;">Editar Categoria</h1>
	<form method="POST">
		<label for="nombre">Nombre:</label>
		<input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($categoria->Nombre, ENT_QUOTES, 'UTF-8') ?>" required>

		<label for="descripcion">Descripcion:</label>
		<input type="text" id="descripcion" name="descripcion" value="<?= htmlspecialchars($categoria->Descripcion, ENT_QUOTES, 'UTF-8') ?>" required>

		<button type="submit">Actualizar</button>
	</form>
</body>
</html>
