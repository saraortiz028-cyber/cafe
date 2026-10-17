<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <?php include __DIR__ . '/../navbar.php'; ?>
    
    <h1>Clientes</h1>
    <p><a href="index.php?controlador=cliente&accion=crear">Nuevo Cliente</a></p>
    
    <table>
        <tr>
            <th>ID</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Direccion</th>
            <th>Fecha de Registro</th>
            <th>Acciones</th>
        </tr>
        <?php while($c = $clientes->fetch_object()): ?>
        <tr>
            <td><?= htmlspecialchars((string) $c->IdCliente, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) $c->Nombres, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) $c->Apellidos, ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) ($c->Telefono ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) ($c->Correo ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) ($c->Direccion ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td><?= htmlspecialchars((string) ($c->FechaRegistro ?? ''), ENT_QUOTES, 'UTF-8') ?></td>
            <td>
                <a href="index.php?controlador=cliente&accion=editar&id=<?= (int) $c->IdCliente ?>">Editar</a>
                <a href="index.php?controlador=cliente&accion=eliminar&id=<?= (int) $c->IdCliente ?>" 
                 onclick="return confirm('¿Eliminar este cliente?')">Eliminar</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>