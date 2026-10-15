<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Nuevo IVA</title>
	<link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
	<h1>Nuevo valor de IVA</h1>
	<form method="POST">
		<label for="IVA">IVA (%):</label>
		<input type="number" id="IVA" name="IVA" min="0" max="999.99" step="0.01" required>

		<button type="submit">Guardar</button>
	</form>
</body>
</html>
