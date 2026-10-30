(function () {
    const endpoint =
        'index.php?controlador=home&accion=estadisticas';

    const formatoDinero = new Intl.NumberFormat('es-NI', {
        style: 'currency',
        currency: 'NIO'
    });

    const formatoNumero = new Intl.NumberFormat('es-NI');

    function actualizarTexto(id, valor) {
        const elemento = document.getElementById(id);

        if (elemento) {
            elemento.textContent = valor;
        }
    }

    function actualizarVariacion(id, variacion) {
        const elemento = document.getElementById(id);

        if (!elemento) {
            return;
        }

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

    function actualizarProductos(productos) {
        const contenedor = document.getElementById('lista-productos');

        if (!contenedor) {
            return;
        }

        contenedor.replaceChildren();

        if (!productos.length) {
            const mensaje = document.createElement('div');

            mensaje.className = 'empty-state';
            mensaje.textContent =
                'Todavía no hay productos vendidos esta semana.';

            contenedor.appendChild(mensaje);

            return;
        }

        const maximo = Math.max(
            1,
            ...productos.map(p => Number(p.unidades_vendidas))
        );

        productos.forEach(producto => {
            const unidades = Number(producto.unidades_vendidas);

            const fila = document.createElement('div');
            fila.className = 'product-row';

            const informacion = document.createElement('div');
            informacion.className = 'product-info';

            const nombre = document.createElement('span');
            nombre.className = 'product-name';
            nombre.textContent = producto.Nombre;

            const cantidad = document.createElement('span');
            cantidad.className = 'product-quantity';
            cantidad.textContent =
                formatoNumero.format(unidades) +
                (unidades === 1 ? ' unidad' : ' unidades');

            informacion.append(nombre, cantidad);

            const pista = document.createElement('div');
            pista.className = 'product-bar-track';

            const barra = document.createElement('div');
            barra.className = 'product-bar';
            barra.style.width = (unidades / maximo * 100) + '%';

            pista.appendChild(barra);
            fila.append(informacion, pista);

            contenedor.appendChild(fila);
        });
    }

    async function actualizarDashboard() {
        try {
            const respuesta = await fetch(endpoint, {
                cache: 'no-store',
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (respuesta.status === 401 ||
                respuesta.redirected) {
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

            actualizarTexto(
                'ventas-semana',
                formatoNumero.format(e.ventas_semana)
            );

            actualizarTexto(
                'ventas-anteriores',
                formatoDinero.format(e.ventas_semana_anterior)
            );

            actualizarVariacion(
                'variacion-ventas',
                e.variacion_ventas
            );

            actualizarTexto(
                'total-clientes',
                formatoNumero.format(e.total_clientes)
            );

            actualizarTexto(
                'clientes-semana',
                formatoNumero.format(e.clientes_semana)
            );

            actualizarTexto(
                'clientes-anteriores',
                formatoNumero.format(e.clientes_semana_anterior)
            );

            actualizarVariacion(
                'variacion-clientes',
                e.variacion_clientes
            );

            actualizarTexto(
                'compras-semana',
                formatoNumero.format(e.compras_semana)
            );

            actualizarTexto(
                'compras-anteriores',
                formatoNumero.format(e.compras_semana_anterior)
            );

            actualizarVariacion(
                'variacion-compras',
                e.variacion_compras
            );

            actualizarProductos(datos.productos);

        } catch (error) {
            console.error(
                'No se pudo actualizar el dashboard:',
                error
            );
        }
    }

    // Actualizar cada 30 segundos.
    actualizarDashboard();
setInterval(actualizarDashboard, 30000);
})();