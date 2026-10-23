<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sucursales | Cafetería</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

<header class="site-header">
    <a href="index.php" class="brand">☕ Cafetería</a>

    <nav class="public-nav">
        <a href="index.php">Inicio</a>
        <a href="index.php?controlador=publico&accion=productos">Productos</a>
        <a href="index.php?controlador=publico&accion=categorias">Categorías</a>
        <a href="index.php?controlador=publico&accion=sucursales">Sucursales</a>
    </nav>
</header>

<main class="container">
    <h1>Nuestras sucursales</h1>
    <p>Encuentra tu sucursal de nuestra cafetería.</p>

    <section class="menu-grid">
        <?php if ($sucursales && $sucursales->num_rows > 0): ?>

            <?php while ($sucursal = $sucursales->fetch_object()): ?>
                <article class="menu-card">
                    <div class="card-copy">
                        <h2>
                            <?= htmlspecialchars($sucursal->Nombre, ENT_QUOTES, 'UTF-8') ?>
                        </h2>

                        <p>
                            <?= htmlspecialchars($sucursal->Direccion ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    </div>
                </article>
            <?php endwhile; ?>

        <?php else: ?>
            <p>No hay sucursales disponibles por el momento.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>