<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Editar IVA</title>
	<link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
	<h1 style="text-align: center;">Editar valor de IVA</h1>
	<form method="POST">
		<label for="IVA">IVA (%):</label>
		<input type="number" id="IVA" name="IVA" min="0" max="999.99" step="0.01" value="<?= htmlspecialchars((string) $configuracion->IVA, ENT_QUOTES, 'UTF-8') ?>" required>

		<button type="submit">Actualizar</button>
	</form>
</body>
</html>
