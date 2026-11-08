<?php

require_once "models/Productos.php";
require_once "models/Categorias.php";
require_once "models/Sucursal.php";
require_once "models/Pedido.php";
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

    // Registrar un pedido desde el catálogo público.
    public function confirmarPedido()
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

        $detallesPedido = [];

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
                $detallesPedido[] = [
                    'id_producto' => $idProducto,
                    'cantidad' => $cantidad,
                    'precio' => $productos[$idProducto]['precio']
                ];
            }
        }

        if (empty($detallesPedido) && !isset($error)) {
            $error = "Selecciona al menos un producto.";
        }

        if (!isset($error)) {
            try {
                require_once "config/database.php";

                $db = Database::conectar();

                // Obtener una sucursal existente.
                $resultadoSucursal = $db->query(
                    "SELECT IdSucursal FROM sucursales
                     ORDER BY IdSucursal LIMIT 1"
                );

                $sucursal = $resultadoSucursal->fetch_object();

                $db->close();

                if (!$sucursal) {
                    throw new Exception(
                        "No hay sucursales registradas."
                    );
                }

                // Registrar el pedido sin cliente ni empleado.
                // El empleado se asignará cuando apruebe el pedido.
                $pedidoCreado = Pedido::crearConDetalles(
                    null,
                    (int) $sucursal->IdSucursal,
                    $detallesPedido
                );

                // Enviar al cliente a consultar su pedido.
                header(
                    "Location: index.php?controlador=publico&accion=pedido&numero="
                    . urlencode($pedidoCreado['numero'])
                );
                exit;

            } catch (Throwable $exception) {
                error_log(
                    "Error al registrar pedido público: "
                    . $exception->getMessage()
                );

                $error = "No se pudo registrar el pedido. Inténtalo nuevamente.";
            }
        }

        // Si ocurre un error, volver a mostrar los productos.
        $productos = Producto::obtenerTodos();

        require "views/publico/productos.php";
    }

    // Consultar el estado de un pedido.
    // Consultar el estado de un pedido.
public function pedido()
{
    $numero = trim($_GET['numero'] ?? '');

    $pedido = null;
    $detalles = [];

    if ($numero !== '') {
        $pedido = Pedido::obtenerPorNumero($numero);

        if ($pedido) {
            $detalles = Pedido::obtenerDetalles($pedido->IdPedido);
        }
    }

    require "views/publico/pedidos.php";
}

    // Se conserva para consultar recibos de ventas existentes.
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

        require "views/publico/recibo.php";
    }
}