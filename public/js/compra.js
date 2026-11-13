const quantityInputs = document.querySelectorAll('.cantidad-producto');
const totalElement = document.querySelector('[data-compra-total]');

// ==========================================
// CÁLCULO DEL TOTAL
// ==========================================

function updatePurchaseTotal() {
    if (!totalElement) {
        return;
    }

    const total = [...quantityInputs].reduce((sum, input) => {
        const quantity = Number.parseInt(input.value, 10);
        const price = Number.parseFloat(input.dataset.precio);

        return sum + (Number.isInteger(quantity) && quantity > 0 ? quantity * price : 0);
    }, 0);

    totalElement.textContent = total.toLocaleString('es-NI', {
        style: 'currency',
        currency: 'NIO'
    });
}

quantityInputs.forEach((input) => {
    input.addEventListener('input', updatePurchaseTotal);
});

updatePurchaseTotal();


// ==========================================
// FILTRO DE EMPLEADOS POR SUCURSAL
// ==========================================

const sucursalSelect = document.getElementById('id_sucursal');
const empleadoSelect = document.getElementById('id_empleado');

async function cargarEmpleados(idSucursal, empleadoSeleccionado = '') {

    empleadoSelect.innerHTML = '';

    if (!idSucursal) {
        empleadoSelect.disabled = true;
        empleadoSelect.innerHTML = '<option value="">Primero selecciona una sucursal</option>';
        return;
    }

    empleadoSelect.disabled = true;
    empleadoSelect.innerHTML = '<option value="">Cargando empleados...</option>';

    try {
        const respuesta = await fetch(
            `index.php?controlador=venta&accion=empleadosPorSucursal&id_sucursal=${encodeURIComponent(idSucursal)}`
        );

        if (!respuesta.ok) {
            throw new Error('No fue posible cargar los empleados.');
        }

        const empleados = await respuesta.json();

        empleadoSelect.innerHTML = '';

        if (empleados.length === 0) {
            empleadoSelect.innerHTML = '<option value="">No hay empleados en esta sucursal</option>';
            return;
        }

        empleadoSelect.innerHTML = '<option value="">Selecciona un empleado</option>';

        empleados.forEach((empleado) => {
            const opcion = document.createElement('option');

            opcion.value = empleado.IdEmpleado;
            opcion.textContent = `${empleado.Nombre} ${empleado.Apellido}`;

            if (String(empleado.IdEmpleado) === String(empleadoSeleccionado)) {
                opcion.selected = true;
            }

            empleadoSelect.appendChild(opcion);
        });

        empleadoSelect.disabled = false;

    } catch (error) {
        empleadoSelect.innerHTML = '<option value="">Error al cargar empleados</option>';
        console.error(error);
    }
}


// Detectar cambios de sucursal
if (sucursalSelect && empleadoSelect) {

    sucursalSelect.addEventListener('change', () => {
        cargarEmpleados(sucursalSelect.value);
    });

    // Recuperar selección después de un error de validación
    const empleadoSeleccionado = empleadoSelect.dataset.empleadoSeleccionado || '';

    if (sucursalSelect.value) {
        cargarEmpleados(sucursalSelect.value, empleadoSeleccionado);
    }
}