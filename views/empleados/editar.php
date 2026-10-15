<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Empleado</title>
    <link rel="stylesheet" href="public/css/estilo.css">
</head>
<body>
    <h1>Editar Empleado</h1>
    <form method="POST">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= 
        htmlspecialchars($empleado->Nombre ?? '') ?>" required>

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" value="<?= 
        htmlspecialchars($empleado->Apellido ?? '') ?>" required>

        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" value="<?= 
        htmlspecialchars($empleado->Direccion ?? '') ?>">

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" value="<?= 
        htmlspecialchars($empleado->Telefono ?? '') ?>">

        <label for="correo">Correo Electronico:</label>
        <input type="email" id="correo" name="correo" value="<?= 
        htmlspecialchars($empleado->Correo ?? '') ?>">

        <label for="salario">Salario:</label>
        <input type="number" step="0.01" id="salario" name="salario" value="<?= 
        htmlspecialchars($empleado->Salario ?? '') ?>">

        <label for="id_cargo">ID Cargo:</label>
        <input type="number" id="id_cargo" name="id_cargo" value="<?= 
        htmlspecialchars($empleado->IdCargo ?? '') ?>">

        <label for="id_sucursal">ID Sucursal:</label>
        <input type="number" id="id_sucursal" name="id_sucursal" value="<?= 
        htmlspecialchars($empleado->IdSucursal ?? '') ?>">

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>