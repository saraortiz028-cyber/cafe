<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cafetería - Inicio</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
    <header class="site-header">
        <div class="admin-brand">
            <img src="public/img/logo_cafe_aroma.png"
            alt="Logo de Café Aroma"
            class="admin-logo">
        </div>

    </header>

    <section class="hero">
        <div class="hero-copy">
            <div class="eyebrow"><span></span> BIENVENIDO A NUESTRA CAFETERÍA</div>

            <h1>Descubre el sabor de nuestra <em>Cafetería</em></h1>

            <p class="hero-description">
                Conoce nuestros productos, explora las diferentes categorías
                y encuentra información sobre nuestras sucursales.
                ¡Tenemos algo para cada gusto!
            </p>

            <div class="hero-actions">
                <a href="index.php?controlador=publico&accion=productos"
                   class="button button-dark">
                    Ver productos
                </a>

                <a href="index.php?controlador=publico&accion=categorias"
                   class="button button-dark">
                    Explorar categorías <span>&rarr;</span>
                </a>
            </div>
        </div>

        <div class="hero-art">
            <div class="coffee-cup">
                <div class="cup-rim"><span></span></div>
                <div class="cup-body"><span class="cup-mark"></span></div>
                <div class="cup-handle"></div>
                <div class="cup-saucer"></div>
            </div>
        </div>
    </section>

    <section class="section-wrap menu-section">
        <div class="section-heading">
            <div>
                <div class="eyebrow"><span></span> CONOCE NUESTRA OFERTA</div>
                <h2>Explora nuestra cafetería</h2>
            </div>

            <p>
                Descubre lo que tenemos para ti y conoce más sobre
                nuestros productos y establecimientos.
            </p>
        </div>

        <div class="menu-grid">
            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">01</span>
                    <h3>Productos</h3>
                    <p>Consulta nuestros productos, sus descripciones y precios.</p>

                    <a href="index.php?controlador=publico&accion=productos"
                       class="button button-dark">
                        Ver productos <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">02</span>
                    <h3>Categorías</h3>
                    <p>Descubre las diferentes categorías de nuestra cafetería.</p>

                    <a href="index.php?controlador=publico&accion=categorias"
                       class="button button-dark">
                        Ver categorías <span>&rarr;</span>
                    </a>
                </div>
            </div>

            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">03</span>
                    <h3>Sucursales</h3>
                    <p>Consulta la información de nuestras sucursales.</p>

                    <a href="index.php?controlador=publico&accion=sucursales"
                       class="button button-dark">
                        Conocer más <span>&rarr;</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="brand footer-brand">
            <div class="brand-icon">☕</div>
            <strong>Cafetería</strong>
        </div>

        <p>Conoce nuestros productos y disfruta de nuestra cafetería.</p>
    </footer>
</body>
</html>