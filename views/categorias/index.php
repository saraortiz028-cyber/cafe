<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Categorias</title>
	<link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>
	<h1>Categorias</h1>
	<a href="index.php?controlador=categoria&accion=crear">Nueva Categoria</a>
	<table>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Descripción</th>
			<th>Acciones</th>
		</tr>
		<?php while ($categoria = $categorias->fetch_object()): ?>
			<tr>
				<td><?= htmlspecialchars($categoria->IdCategoria, ENT_QUOTES, 'UTF-8') ?></td>
				<td><?= htmlspecialchars($categoria->Nombre, ENT_QUOTES, 'UTF-8') ?></td>
				<td><?= htmlspecialchars($categoria->Descripcion, ENT_QUOTES, 'UTF-8') ?></td>
				<td>
					<a href="index.php?controlador=categoria&accion=editar&id=<?= urlencode($categoria->IdCategoria) ?>">Editar</a>
					<a href="index.php?controlador=categoria&accion=eliminar&id=<?= urlencode($categoria->IdCategoria) ?>"
                   onclick="return confirm('¿Eliminar esta categoría?')">Eliminar</a>
				</td>
			</tr>
		<?php endwhile; ?>
	</table>
</body>
</html>
