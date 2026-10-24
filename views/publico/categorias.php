<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categorías | Cafetería</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

<?php include __DIR__ . '/../navbar_publico.php'; ?>

<main class="categorias-page">

    <section class="categorias-hero">
        <span class="categorias-eyebrow">HECHO PARA DISFRUTAR</span>

        <h1>Nuestras categorías</h1>

        <p>
            Cada antojo tiene su lugar. Explora las categorías
            y descubre tus favoritos de nuestra cafetería.
        </p>

        <span class="categorias-decoracion">☕</span>
    </section>

    <section class="categorias-contenido">

        <div class="categorias-encabezado">
            <div>
                <span class="categorias-etiqueta">NUESTRA VARIEDAD</span>
                <h2>Explora el menú</h2>
            </div>

            <p>Encuentra algo delicioso para tu próximo descanso.</p>
        </div>

        <div class="categorias-grid">

            <?php if ($categorias && $categorias->num_rows > 0): ?>

                <?php $numeroCategoria = 0; ?>

                <?php while ($categoria = $categorias->fetch_object()): ?>

                    <?php $numeroCategoria++; ?>

                    <article class="categoria-card">

                        <span class="categoria-numero">
                            <?= str_pad((string) $numeroCategoria, 2, '0', STR_PAD_LEFT) ?>
                        </span>

                        <div class="categoria-icono">☕</div>

                        <h3>
                            <?= htmlspecialchars(
                                $categoria->Nombre,
                                ENT_QUOTES,
                                'UTF-8'
                            ) ?>
                        </h3>

                        <span class="categoria-linea"></span>

                    </article>

                <?php endwhile; ?>

            <?php else: ?>

                <div class="categorias-vacio">
                    <span>☕</span>
                    <h3>Pronto habrá novedades</h3>
                    <p>No hay categorías disponibles por el momento.</p>
                </div>

            <?php endif; ?>

        </div>

        <div class="categorias-accion">
            <p>¿Ya sabes qué se te antoja?</p>

            <a href="index.php?controlador=publico&accion=productos"
               class="categorias-boton">
                Explorar productos <span aria-hidden="true">→</span>
            </a>
        </div>

    </section>

</main>

<footer class="site-footer">
    <div class="brand footer-brand">
        <div class="brand-icon">☕</div>
        <strong>Cafetería</strong>
    </div>

    <p>Un buen café siempre es una buena idea.</p>
</footer>

</body>
</html>