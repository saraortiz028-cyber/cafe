<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

    <h1 style="text-align: center;">Editar Cliente</h1>
    <form method="POST">
        <label for="nombres">Nombres:</label>
        <input type="text" id="nombres" name="nombres" value="<?= 
        htmlspecialchars($cliente->Nombres) ?>" required>
        <!--lo de htmlspecialchars es para tener mayor seguridad-->
        
        <label for="apellidos">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" value="<?= 
        htmlspecialchars($cliente->Apellidos) ?>" required>

        <label for="telefono">Telefono:</label>
        <input type="text" id="telefono" name="telefono" value="<?= 
        htmlspecialchars($cliente->Telefono) ?>">

        <label for="correo">Correo Electronico:</label>
        <input type="email" id="correo" name="correo" value="<?= 
        htmlspecialchars($cliente->Correo) ?>">

        <label for="direccion">Direccion:</label>
        <input type="text" id="direccion" name="direccion" value="<?= 
        htmlspecialchars($cliente->Direccion) ?>">

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>