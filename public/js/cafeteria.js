const employeeCount = document.querySelector('[data-summary="empleados"]');
const customerCount = document.querySelector('[data-summary="clientes"]');
const summaryStatus = document.querySelector('[data-summary-status]');
const retryButton = document.querySelector('[data-summary-retry]');

async function loadCommunitySummary() {
    if (!employeeCount || !customerCount || !summaryStatus || !retryButton) {
        return;
    }

    retryButton.hidden = true;
    summaryStatus.textContent = 'Consultando la base de datos…';

    try {
        const response = await fetch('api/resumen.php', {
            headers: { Accept: 'application/json' }
        });
        if (!response.ok) {
            throw new Error(`La consulta respondió con HTTP ${response.status}`);
        }

        const summary = await response.json();
        if (!Number.isSafeInteger(summary.empleados) || !Number.isSafeInteger(summary.clientes)
            || summary.empleados < 0 || summary.clientes < 0) {
            throw new Error('La respuesta de la base de datos no tiene el formato esperado');
        }

        employeeCount.textContent = summary.empleados.toLocaleString('es-MX');
        customerCount.textContent = summary.clientes.toLocaleString('es-MX');
        summaryStatus.textContent = 'Totales consultados desde la base de datos.';
    } catch (error) {
        employeeCount.textContent = '—';
        customerCount.textContent = '—';
        summaryStatus.textContent = 'No se pudo consultar MySQL. Inicia la aplicación y vuelve a intentarlo.';
        retryButton.hidden = false;
        console.error('No fue posible cargar el resumen de empleados y clientes:', error);
    }
}

retryButton.addEventListener('click', loadCommunitySummary);
loadCommunitySummary();
