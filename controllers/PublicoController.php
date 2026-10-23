<?php

require_once "models/Productos.php";
require_once "models/Categorias.php";
require_once "models/Sucursal.php";
require_once "models/Venta.php";
require_once "models/DetalleVenta.php";

class PublicoController
{
    public function productos()
    {
        $productos = Producto::obtenerTodos();
        require "views/publico/productos.php";
    }

    public function categorias()
    {
        $categorias = Categoria::obtenerTodos();
        require "views/publico/categorias.php";
    }

    public function sucursales()
    {
        $sucursales = Sucursal::obtenerTodos();
        require "views/publico/sucursales.php";
    }

    public function confirmarCompra()
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            header("Location: index.php?controlador=publico&accion=productos");
            exit;
        }

        $productosSeleccionados = $_POST['productos'] ?? [];

        if (!is_array($productosSeleccionados)) {
            header("Location: index.php?controlador=publico&accion=productos");
            exit;
        }

        $resultado = Producto::obtenerTodos();
        $productos = [];

        while ($producto = $resultado->fetch_object()) {
            $productos[(int) $producto->IdProducto] = [
                'nombre' => $producto->Nombre,
                'precio' => (float) $producto->Precio
            ];
        }

        $detallesCompra = [];

        foreach ($productosSeleccionados as $id => $cantidadIngresada) {
            $idProducto = filter_var($id, FILTER_VALIDATE_INT);

            if (
                $idProducto === false ||
                !isset($productos[$idProducto]) ||
                (!is_string($cantidadIngresada) && !is_int($cantidadIngresada))
            ) {
                $error = "Los productos seleccionados no son válidos.";
                break;
            }

            $cantidad = filter_var($cantidadIngresada, FILTER_VALIDATE_INT);

            if ($cantidad === false || $cantidad < 0 || $cantidad > 1000) {
                $error = "Las cantidades deben estar entre 0 y 1000.";
                break;
            }

            if ($cantidad > 0) {
                $detallesCompra[] = [
                    'id_producto' => $idProducto,
                    'cantidad' => $cantidad,
                    'precio' => $productos[$idProducto]['precio']
                ];
            }
        }

        if (empty($detallesCompra) && !isset($error)) {
            $error = "Selecciona al menos un producto.";
        }

        if (!isset($error)) {
            try {
                require_once "config/database.php";
                $db = Database::conectar();

                // Obtener un empleado y una sucursal existentes.
                $resultadoEmpleado = $db->query(
                    "SELECT IdEmpleado FROM empleados ORDER BY IdEmpleado LIMIT 1"
                );

                $resultadoSucursal = $db->query(
                    "SELECT IdSucursal FROM sucursales ORDER BY IdSucursal LIMIT 1"
                );

                $empleado = $resultadoEmpleado->fetch_object();
                $sucursal = $resultadoSucursal->fetch_object();

                $db->close();

                if (!$empleado || !$sucursal) {
                    throw new Exception(
                        "Se necesita al menos un empleado y una sucursal registrados."
                    );
                }

                // Registrar la compra y descontar existencias.
                $idVenta = Venta::guardarConDetalles(
                    null,
                    (int) $empleado->IdEmpleado,
                    (int) $sucursal->IdSucursal,
                    $detallesCompra
                );

                // Reutilizar la información del recibo administrativo.
                header(
                    "Location: index.php?controlador=publico&accion=recibo&id="
                    . $idVenta
                );
                exit;

            } catch (Throwable $exception) {
                error_log(
                    "Error en compra pública: " . $exception->getMessage()
                );

                $error = strpos(
                    $exception->getMessage(),
                    "No hay existencias suficientes"
                ) !== false
                    ? $exception->getMessage()
                    : "No se pudo completar la compra. Inténtalo nuevamente.";
            }
        }

        // Si ocurre un error, volver a mostrar los productos.
        $resultado = Producto::obtenerTodos();
        $productos = $resultado;

        require "views/publico/productos.php";
    }

    public function recibo()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        $venta = $id ? Venta::obtenerParaRecibo($id) : null;

        if (!$venta) {
            http_response_code(404);
            echo "La compra solicitada no existe.";
            return;
        }

        $detalles = DetalleVenta::obtenerPorVenta($id);

        require "views/venta_y_detalle/recibo.php";
    }
}