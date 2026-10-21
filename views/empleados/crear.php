<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nuevo Empleado</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
    <h1 style="text-align: center;">Nuevo Empleado</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" placeholder="Apellido" required>

        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" placeholder="Direccion">

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" placeholder="Telefono">

        <label for="correo">Correo Electronico:</label>
        <input type="email" id="correo" name="correo" placeholder="Correo Electronico">

        <label for="salario">Salario:</label>
        <input type="number" step="0.01" id="salario" name="salario" placeholder="Salario">

        <label for="id_cargo">Cargo:</label>
        <select id="id_cargo" name="id_cargo" required>
            <option value="">Selecciona un cargo</option>
            <?php while ($c = $cargos->fetch_object()): ?>
                <option value="<?= (int) $c->IdCargo ?>"><?= htmlspecialchars($c->NombreCargo, ENT_QUOTES, 'UTF-8') ?></option>
            <?php endwhile; ?>
        </select>

        <label for="id_sucursal">Sucursal:</label>
        <select id="id_sucursal" name="id_sucursal" required>
            <option value="">Selecciona una sucursal</option>
            <?php while ($s = $sucursales->fetch_object()): ?>
                <option value="<?= (int) $s->IdSucursal ?>"><?= htmlspecialchars($s->Nombre, ENT_QUOTES, 'UTF-8') ?></option>
            <?php endwhile; ?>
        </select>
        
        <button type="submit">Guardar</button>
    </form>
</body>
</html>