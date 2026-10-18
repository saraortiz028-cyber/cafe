<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Configuracion del IVA</title>
	<link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>
	<h1>Configuracion del IVA</h1>
	<a href="index.php?controlador=configuracion&accion=crear" class="button button-dark">Nuevo valor de IVA</a>
	<table>
		<tr>
			<th>ID</th>
			<th>IVA (%)</th>
			<th>Acciones</th>
		</tr>
		<?php while ($configuracion = $configuraciones->fetch_object()): ?>
			<tr>
				<td><?= htmlspecialchars((string) $configuracion->IdConfiguracion, ENT_QUOTES, 'UTF-8') ?></td>
				<td><?= htmlspecialchars(number_format((float) $configuracion->IVA, 2, '.', ''), ENT_QUOTES, 'UTF-8') ?></td>
				<td>
					<a href="index.php?controlador=configuracion&accion=editar&id=<?= urlencode((string) $configuracion->IdConfiguracion) ?>">Editar</a>
					<a href="index.php?controlador=configuracion&accion=eliminar&id=<?= urlencode((string) $configuracion->IdConfiguracion) ?>"
                   onclick="return confirm('¿Eliminar esta configuración?')">Eliminar</a>
				</td>
			</tr>
		<?php endwhile; ?>
	</table>
</body>
</html>
