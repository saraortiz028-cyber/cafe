<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cafetería - Panel Principal</title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body>
    <header class="site-header">
        <div class="brand">
            <div class="brand-icon">☕</div>
            <strong>Cafetería</strong>
        </div>
    </header>

    <section class="hero">
        <div class="hero-copy">
            <div class="eyebrow"><span></span> SISTEMA DE GESTIÓN INTERNA</div>
            <h1>Bienvenido al Sistema de la <em>Cafetería</em></h1>
            <p class="hero-description">
                Administra de forma rápida y sencilla los productos, categorías, clientes, empleados, sucursales y operaciones diarias del negocio.
            </p>
            <div class="hero-actions">
                <a href="index.php?controlador=producto&accion=index" class="button button-dark">Gestionar Productos</a>
                <a href="index.php?controlador=venta&accion=index" class="text-link">Ver Ventas<span>&rarr;</span></a>
            </div>
        </div>

        <div class="hero-art">
            <div class="coffee-cup">
                <div class="cup-rim"><span></span></div>
                <div class="cup-body"><span class="cup-mark">☕</span></div>
                <div class="cup-handle"></div>
                <div class="cup-saucer"></div>
            </div>
        </div>
    </section>

    <section class="section-wrap menu-section">
        <div class="section-heading">
            <div>
                <div class="eyebrow"><span></span> MÓDULOS DEL SISTEMA</div>
                <h2>Accesos Rápidos</h2>
            </div>
            <p>Selecciona el módulo que deseas administrar para continuar con tus tareas.</p>
        </div>

        <div class="menu-grid">
            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">01</span>
                    <h3>Productos</h3>
                    <p>Control de stock, precios y descripción de artículos.</p>
                    <a href="index.php?controlador=producto&accion=index" class="text-link">Entrar<span>&rarr;</span></a>
                </div>
            </div>

            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">02</span>
                    <h3>Categorías</h3>
                    <p>Organiza los productos por categorías y tipos.</p>
                    <a href="index.php?controlador=categoria&accion=index" class="text-link">Entrar<span>&rarr;</span></a>
                </div>
            </div>

            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">03</span>
                    <h3>Clientes</h3>
                    <p>Base de datos y registro de clientes frecuentes.</p>
                    <a href="index.php?controlador=cliente&accion=index" class="text-link">Entrar<span>&rarr;</span></a>
                </div>
            </div>

            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">04</span>
                    <h3>Empleados</h3>
                    <p>Gestión de personal y datos del equipo.</p>
                    <a href="index.php?controlador=empleado&accion=index" class="text-link">Entrar<span>&rarr;</span></a>
                </div>
            </div>

            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">05</span>
                    <h3>Sucursales</h3>
                    <p>Ubicaciones y sucursales de la cafetería.</p>
                    <a href="index.php?controlador=sucursal&accion=index" class="text-link">Entrar<span>&rarr;</span></a>
                </div>
            </div>

            <div class="menu-card">
                <div class="card-copy">
                    <span class="card-number">06</span>
                    <h3>Proveedores</h3>
                    <p>Gestión de proveedores y compras de insumos.</p>
                    <a href="index.php?controlador=proveedor&accion=index" class="text-link">Entrar<span>&rarr;</span></a>
                </div>
            </div>
        </div>
    </section>

    <footer class="site-footer">
        <div class="brand footer-brand">
            <div class="brand-icon">☕</div>
            <strong>Cafetería</strong>
        </div>
        <p>Sistema de administración <span>&bull;</span> Panel Principal</p>
    </footer>
</body>
</html>