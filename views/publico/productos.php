<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nuestros productos - Cafetería</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>

    <header class="site-header">
        <div class="brand">
            <div class="brand-icon">☕</div>
            <strong>Cafetería</strong>
        </div>

        <nav class="public-nav">
            <a href="index.php">Inicio</a>
            <a href="index.php?controlador=publico&accion=productos">Productos</a>
            <a href="index.php?controlador=publico&accion=categorias">Categorías</a>
            <a href="index.php?controlador=publico&accion=sucursales">Sucursales</a>
            <a href="index.php?controlador=auth&accion=login">Acceso empleados</a>
        </nav>
    </header>

    <main class="section-wrap menu-section">

        <div class="section-heading">
            <div>
                <div class="eyebrow"><span></span> NUESTRO CATÁLOGO</div>
                <h1>Descubre nuestros productos</h1>
            </div>

            <p>Conoce nuestra oferta, selecciona las cantidades y prepara tu pedido.</p>
        </div>

        <form
        class="compra-form"
        method="POST"
        action="index.php?controlador=publico&accion=confirmarCompra">

            <div class="menu-grid">

                <?php if ($productos && $productos->num_rows > 0): ?>

                    <?php while ($producto = $productos->fetch_object()): ?>

                        <article class="menu-card">
                            <div class="card-copy">

                                <span class="card-number">
                                    <?= htmlspecialchars(
                                        $producto->NombreCategoria ?? 'Cafetería',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>

                                <h2>
                                    <?= htmlspecialchars(
                                        $producto->Nombre,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </h2>

                                <p>
                                    <?= htmlspecialchars(
                                        $producto->Descripcion ?? '',
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </p>

                                <p>
                                    <strong>Precio:</strong>
                                    $<?= number_format((float) $producto->Precio, 2) ?> NIO
                                </p>

                                <label for="producto-<?= (int) $producto->IdProducto ?>">
                                    <strong>Cantidad:</strong>
                                </label>

                                <input
                                    class="cantidad-producto"
                                    type="number"
                                    id="producto-<?= (int) $producto->IdProducto ?>"
                                    name="productos[<?= (int) $producto->IdProducto ?>]"
                                    min="0"
                                    max="1000"
                                    value="0"
                                    data-precio="<?= htmlspecialchars(
                                        (string) $producto->Precio,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>"
                                >

                            </div>
                        </article>

                    <?php endwhile; ?>

                <?php else: ?>

                    <p>Actualmente no hay productos disponibles.</p>

                <?php endif; ?>

            </div>

            <?php if ($productos && $productos->num_rows > 0): ?>

                <p class="compra-total">Total estimado: <strong data-compra-total>$0.00 NIO</strong></p>
        <button type="submit">Confirmar compra y generar recibo</button>

            <?php endif; ?>

        </form>

        <p style="margin-top: 25px;">
            <a href="index.php" class="button button-dark">
                Volver al inicio
            </a>
        </p>

    </main>

    <footer class="site-footer">
        <div class="brand footer-brand">
            <div class="brand-icon">☕</div>
            <strong>Cafetería</strong>
        </div>

        <p>Descubre nuestros productos.</p>
    </footer>

    <script src="public/js/compra.js" defer></script>

</body>
</html>