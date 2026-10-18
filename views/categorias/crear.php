<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Nueva Categoria</title>
	<link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
	<h1 style="text-align: center;">Nueva Categoria</h1>
	<form method="POST">
		<label for="nombre" class="form-label">Nombre de la Categoría</label>
        <input type="text" class="form-control" id="nombre" name="nombre" required>

        <label for="descripcion" class="form-label">Descripción</label>
		<input type="text" class="form-control" id="descripcion" name="descripcion" required>

		<button type="submit">Guardar</button>
	</form>
</body>
</html>
