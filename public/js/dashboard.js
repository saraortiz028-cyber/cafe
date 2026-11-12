(function () {

    const endpoint =
        'index.php?controlador=home&accion=estadisticas';

    const formatoNumero = new Intl.NumberFormat('es-NI');

    let graficoVentas = null;

    function actualizarGraficoVentas(datos) {
    const canvas = document.getElementById('grafico-ventas');
    if (!canvas) return;

    const etiquetas = datos.map(dia => dia.dia);
    const valores = datos.map(dia => dia.ventas);

    if (!graficoVentas) {

        graficoVentas = new Chart(canvas, {
            type: 'bar',

            data: {
                labels: etiquetas,

                datasets: [{
                    label: 'Ventas',
                    data: valores,
                    backgroundColor: '#354A36',
                    borderRadius: 6,
                    maxBarThickness: 45
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Ventas: ' +
                                    (context.raw ?? 'Sin datos');
                            }
                        }
                    }
                },

                scales: {
                    y: {
                        beginAtZero: true,

                        ticks: {
                            precision: 0
                        },

                        title: {
                            display: true,
                            text: 'Cantidad de ventas'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

    } else {

        graficoVentas.data.labels = etiquetas;
        graficoVentas.data.datasets[0].data = valores;

        graficoVentas.update();
    }
}

    // Actualizar texto de un elemento.
    function actualizarTexto(id, valor) {

        const elemento = document.getElementById(id);

        if (elemento) {
            elemento.textContent = valor;
        }

    }

    // Actualizar variaciones de las tarjetas.
    function actualizarVariacion(id, variacion) {

        const elemento = document.getElementById(id);

        if (!elemento) return;

        elemento.textContent = variacion.texto;

        elemento.classList.remove(
            'trend-up',
            'trend-down',
            'trend-neutral'
        );

        if (variacion.tipo === 'subida') {

            elemento.classList.add('trend-up');

        } else if (variacion.tipo === 'bajada') {

            elemento.classList.add('trend-down');

        } else {

            elemento.classList.add('trend-neutral');

        }

    }

    // Actualizar fechas de comparación.
    function actualizarPeriodos(estadisticas) {
    const subtitulo = document.getElementById('periodo-dashboard');

    if (!subtitulo) return;

    subtitulo.replaceChildren();

    subtitulo.append('Comparación semanal: ');

    const periodoAnterior = document.createElement('strong');
    periodoAnterior.textContent = estadisticas.periodo_anterior;

    const periodoActual = document.createElement('strong');
    periodoActual.textContent = estadisticas.periodo_actual;

    subtitulo.append(
        periodoAnterior,
        ' vs. ',
        periodoActual
    );
}

    // Crear imagen del producto.
    function crearImagen(producto) {

        const contenedor = document.createElement('div');

        contenedor.className = 'dash-product-image';

        const imagen = document.createElement('img');

        const alternativa = document.createElement('div');

        alternativa.className = 'dash-product-no-image';
        alternativa.textContent = '☕';
        alternativa.style.display = 'none';

        imagen.src = 'public/img/productos/' +
            encodeURIComponent(producto.Imagen || '');

        imagen.alt = producto.Nombre || 'Producto';

        imagen.loading = 'lazy';

        imagen.onerror = function () {

            imagen.style.display = 'none';
            alternativa.style.display = 'grid';

        };

        if (!producto.Imagen) {

            imagen.style.display = 'none';
            alternativa.style.display = 'grid';

        }

        contenedor.append(imagen, alternativa);

        return contenedor;

    }

    // Actualizar productos más vendidos.
    function actualizarProductos(productos) {

        const contenedor = document.getElementById('lista-productos');

        if (!contenedor) return;

        contenedor.replaceChildren();

        if (!productos || productos.length === 0) {

            const mensaje = document.createElement('p');

            mensaje.textContent = 'Todavía no hay productos vendidos.';

            contenedor.appendChild(mensaje);

            return;

        }

        const maximo = Math.max(
            1,
            ...productos.map(p => Number(p.unidades_vendidas))
        );

        productos.forEach(producto => {

            const unidades = Number(producto.unidades_vendidas);

            const porcentaje = (unidades / maximo) * 100;

            const fila = document.createElement('div');

            fila.className = 'dash-product-item';

            // Imagen.
            fila.appendChild(crearImagen(producto));

            // Contenido.
            const contenido = document.createElement('div');

            contenido.className = 'dash-product-content';

            // Nombre y cantidad.
            const informacion = document.createElement('div');

            informacion.className = 'dash-product-info';

            const nombre = document.createElement('span');

            nombre.textContent = producto.Nombre;

            const cantidad = document.createElement('strong');

            cantidad.textContent = formatoNumero.format(unidades);

            informacion.append(nombre, cantidad);

            // Barra de progreso.
            const pista = document.createElement('div');

            pista.className = 'dash-product-bar-bg';

            const barra = document.createElement('div');

            barra.className = 'dash-product-bar-fill';

            barra.style.width = porcentaje + '%';

            pista.appendChild(barra);

            contenido.append(informacion, pista);

            fila.appendChild(contenido);

            contenedor.appendChild(fila);

        });

    }

    // Actualizar todo el dashboard.
    async function actualizarDashboard() {

        try {

            const respuesta = await fetch(endpoint, {

                cache: 'no-store',

                headers: {
                    'Accept': 'application/json'
                }

            });

            if (respuesta.status === 401 || respuesta.redirected) {

                window.location.reload();

                return;

            }

            if (!respuesta.ok) {

                throw new Error('Error al consultar las estadísticas.');

            }

            const datos = await respuesta.json();

            if (!datos.ok) {

                throw new Error('No se pudieron actualizar los datos.');

            }

            const e = datos.estadisticas;

            // Ventas.
            actualizarTexto(
                'ventas-semana',
                formatoNumero.format(e.ventas_semana)
            );

            actualizarVariacion(
                'variacion-ventas',
                e.variacion_ventas
            );

            // Clientes.
            actualizarTexto(
                'clientes-semana',
                formatoNumero.format(e.clientes_semana)
            );

            actualizarVariacion(
                'variacion-clientes',
                e.variacion_clientes
            );

            // Compras.
            actualizarTexto(
                'compras-semana',
                formatoNumero.format(e.compras_semana)
            );

            actualizarVariacion(
                'variacion-compras',
                e.variacion_compras
            );

            // Fechas de comparación.
            actualizarPeriodos(e);

            // Productos más vendidos.
            actualizarProductos(datos.productos);

            actualizarGraficoVentas(datos.ventasPorDia);

        } catch (error) {

            console.error(
                'No se pudo actualizar el dashboard:',
                error
            );

        }

    }

    // Primera actualización.
    actualizarDashboard();

    // Actualizar cada 30 segundos.
    setInterval(actualizarDashboard, 30000);

})();