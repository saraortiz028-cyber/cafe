<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Iniciar sesión - Cafetería</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

    <div class="section-wrap">

        <h1 style="text-align: center;">Iniciar sesión</h1>

        <p style="text-align: center;">
            Ingresa con tu correo y contraseña de empleado.
        </p>

        <?php if ($error !== null): ?>
            <p role="alert" style="text-align: center;">
                <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="POST"
              action="index.php?controlador=auth&accion=login">

            <input
                type="hidden"
                name="csrf_token"
                value="<?= htmlspecialchars(
                    Auth::csrfToken(),
                    ENT_QUOTES,
                    'UTF-8'
                ) ?>"
            >

            <label for="correo">Correo electrónico:</label>
            <input
                type="email"
                id="correo"
                name="correo"
                autocomplete="username"
                required
            >

            <label for="contrasena">Contraseña:</label>
            <input
                type="password"
                id="contrasena"
                name="contrasena"
                autocomplete="current-password"
                required
            >

            <button type="submit">Iniciar sesión</button>

        </form>

        <p style="text-align: center; margin-top: 20px;">
            <a href="index.php">Volver al inicio</a>
        </p>

    </div>

</body>
</html>