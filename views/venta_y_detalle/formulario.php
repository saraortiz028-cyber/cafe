<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $venta ? 'Editar venta' : 'Nueva venta' ?></title>
    <link rel="stylesheet" href="public/css/cafeteria.css">
</head>
<body class="order-section">

       <div class="section-wrap">

              <h1 style="text-align: center;"><?= $venta ? 'Editar venta' : 'Nueva venta' ?></h1>
       
              <?php if ($error !== null): ?>
              <p role="alert"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
              <?php endif; ?>

              <form method="POST">
                     <label for="fecha">Fecha:</label>
                     <input type="date" id="fecha" name="fecha"
                            value="<?= htmlspecialchars($venta->FechaVenta ?? date('Y-m-d'), ENT_QUOTES, 'UTF-8') ?>" required>
              
                     <label for="id_cliente">Cliente (opcional):</label>
                     <select id="id_cliente" name="id_cliente">
                            <option value="">Sin cliente registrado</option>
                            <?php while ($cliente = $clientes->fetch_object()): ?>
                                   <option value="<?= (int) $cliente->IdCliente ?>" <?= $idClienteSeleccionado === (string) $cliente->IdCliente ? 'selected' : '' ?>>
                                          <?= htmlspecialchars($cliente->Nombres . ' ' . $cliente->Apellidos, ENT_QUOTES, 'UTF-8') ?>
                                   </option>
                            <?php endwhile; ?>
                     </select>

                     <label for="id_sucursal">Sucursal:</label>
                     <select id="id_sucursal" name="id_sucursal" required>
                            <option value="">Selecciona una sucursal</option>

                            <?php while ($sucursal = $sucursales->fetch_object()): ?>

                            <option value="<?= (int) $sucursal->IdSucursal ?>"
                                   <?= $idSucursalSeleccionada === (string) $sucursal->IdSucursal ? 'selected' : '' ?>>

                                   <?= htmlspecialchars($sucursal->Nombre, ENT_QUOTES, 'UTF-8') ?>
                            </option>

                            <?php endwhile; ?>
                     </select>

                     <label for="id_empleado">Empleado:</label>
                     <select id="id_empleado" name="id_empleado"
                            data-empleado-seleccionado="<?= htmlspecialchars($idEmpleadoSeleccionado, ENT_QUOTES, 'UTF-8') ?>"
                            required
                            disabled>

                            <option value="">Selecciona primero una sucursal</option>

                     </select>

                     <button type="submit"><?= $venta ? 'Actualizar' : 'Guardar y agregar detalles' ?></button>
              </form>

              <div style="margin-top: 20px; text-align: center;">
                     <a href="index.php?controlador=venta&accion=index" class="button button-dark">Volver a ventas</a>
              </div>

       </div>

<script>

document.addEventListener('DOMContentLoaded', function () {

       const sucursal = document.getElementById('id_sucursal');
       const empleado = document.getElementById('id_empleado');

       const empleadoSeleccionado = empleado.dataset.empleadoSeleccionado;

       async function cargarEmpleados(idSucursal, idEmpleado = '') {

       empleado.innerHTML = '';

       if (!idSucursal) {

              empleado.disabled = true;

              empleado.add(new Option(
                     'Selecciona primero una sucursal',
                     ''
              ));

              return;
       }

       empleado.disabled = true;

       empleado.add(new Option(
              'Cargando empleados...',
              ''
       ));

       try {

              const respuesta = await fetch(
                     'index.php?controlador=venta&accion=empleadosPorSucursal&id_sucursal='
                     + encodeURIComponent(idSucursal)
              );

              if (!respuesta.ok) {
                throw new Error('No se pudieron obtener los empleados');
            }

            const empleados = await respuesta.json();

            empleado.innerHTML = '';

            empleado.add(new Option(
                'Selecciona un empleado',
                ''
            ));

            empleados.forEach(function (item) {

                const opcion = new Option(
                    item.Nombre + ' ' + item.Apellido,
                    item.IdEmpleado
                );

                empleado.add(opcion);

            });

            empleado.disabled = false;

            if (idEmpleado) {
                empleado.value = idEmpleado;
            }

        } catch (error) {

            empleado.innerHTML = '';

            empleado.add(new Option(
                'Error al cargar empleados',
                ''
            ));

            empleado.disabled = true;

            console.error(error);

        }
    }

    sucursal.addEventListener('change', function () {

        cargarEmpleados(this.value);

    });

    // Cargar empleados automáticamente al editar una venta.
    if (sucursal.value) {

        cargarEmpleados(
            sucursal.value,
            empleadoSeleccionado
        );

    }

});

</script>
</body>
</html>
