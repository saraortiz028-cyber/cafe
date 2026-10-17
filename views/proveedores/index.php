<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Proveedores</title>
	<link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
<?php include __DIR__ . '/../navbar.php'; ?>
	<h1>Proveedores</h1>
	<a href="index.php?controlador=proveedor&accion=crear">Nuevo Proveedor</a>
	<table>
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Telefono</th>
			<th>Correo</th>
			<th>Direccion</th>
			<th>Acciones</th>
		</tr>
		<?php while ($proveedor = $proveedores->fetch_object()): ?>
			<tr>
				<td><?= htmlspecialchars((string) $proveedor->IdProveedor, ENT_QUOTES, 'UTF-8') ?></td>
				<td><?= htmlspecialchars($proveedor->Nombre, ENT_QUOTES, 'UTF-8') ?></td>
				<td><?= htmlspecialchars($proveedor->Telefono, ENT_QUOTES, 'UTF-8') ?></td>
				<td><?= htmlspecialchars($proveedor->Correo ?? '', ENT_QUOTES, 'UTF-8') ?></td>
				<td><?= htmlspecialchars($proveedor->Direccion ?? '', ENT_QUOTES, 'UTF-8') ?></td>
				<td>
					<a href="index.php?controlador=proveedor&accion=editar&id=<?= urlencode((string) $proveedor->IdProveedor) ?>">Editar</a>
					<a href="index.php?controlador=proveedor&accion=eliminar&id=<?= urlencode((string) $proveedor->IdProveedor) ?>"
                   onclick="return confirm('¿Eliminar este proveedor?')">Eliminar</a>
				</td>
			</tr>
		<?php endwhile; ?>
	</table>
</body>
</html>
