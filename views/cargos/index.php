<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Cargos</title>
	<link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>

<div class="admin-content">
	<h1>Cargos</h1>
	<a href="index.php?controlador=cargo&accion=crear" class="button button-dark">Nuevo Cargo</a>
	<a href="index.php" class="button button-dark">Inicio</a></p>
	<table>
		<tr>
			<th>ID</th>
			<th>Nombre del cargo</th>
			<th>Acciones</th>
		</tr>
		<?php while ($cargo = $cargos->fetch_object()): ?>
			<tr>
				<td><?= htmlspecialchars((string) $cargo->IdCargo, ENT_QUOTES, 'UTF-8') ?></td>
				<td><?= htmlspecialchars($cargo->NombreCargo, ENT_QUOTES, 'UTF-8') ?></td>
				<td>
					<a href="index.php?controlador=cargo&accion=editar&id=<?= urlencode((string) $cargo->IdCargo) ?>">Editar</a>
					<a href="index.php?controlador=cargo&accion=eliminar&id=<?= urlencode((string) $cargo->IdCargo) ?>"
                   onclick="return confirm('¿Eliminar este cargo?')">Eliminar</a>
			</tr>
		<?php endwhile; ?>
	</table>
</div>
</body>
</html>
