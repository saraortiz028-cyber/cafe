<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categorías | Cafetería</title>
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
    <h1>Nuestras categorías</h1>
    <p>Descubre las diferentes categorías de nuestra cafetería.</p>

    <section class="menu-grid">
        <?php if ($categorias && $categorias->num_rows > 0): ?>
            <?php while ($categoria = $categorias->fetch_object()): ?>
                <article class="menu-card">
                    <div class="card-copy">
                        <h2>
                            <?= htmlspecialchars($categoria->Nombre, ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                    </div>
                </article>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay categorías disponibles por el momento.</p>
        <?php endif; ?>
    </section>
</main>

</body>
</html>