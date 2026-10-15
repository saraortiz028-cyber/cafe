<?php
require_once "models/Venta.php";
require_once "models/DetalleVenta.php";
require_once "models/Productos.php";
require_once "models/Cliente.php";

class VentaController {
    public function index() {
        $ventas = Venta::obtenerTodos();
        require "views/venta_y_detalle/index.php";
    }

    public function crear() {
        [$empleados, $sucursales] = $this->obtenerOpcionesVenta();
        $clientes = Cliente::obtenerTodos();
        $error = null;
        $idClienteSeleccionado = '';
        $idEmpleadoSeleccionado = '';
        $idSucursalSeleccionada = '';
        $venta = null;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $idClienteSeleccionado = (string) ($_POST['id_cliente'] ?? '');
            $idEmpleadoSeleccionado = (string) ($_POST['id_empleado'] ?? '');
            $idSucursalSeleccionada = (string) ($_POST['id_sucursal'] ?? '');
            $idCliente = $idClienteSeleccionado === '' ? null : $this->idDesdePost('id_cliente');
            $idEmpleado = $this->idDesdePost('id_empleado');
            $idSucursal = $this->idDesdePost('id_sucursal');

            if (($idClienteSeleccionado !== '' && (!$idCliente || !$this->registroExiste('clientes', 'IdCliente', $idCliente))) ||
                !$idEmpleado || !$this->registroExiste('empleados', 'IdEmpleado', $idEmpleado) ||
                !$idSucursal || !$this->registroExiste('sucursales', 'IdSucursal', $idSucursal)) {
                $error = 'Selecciona un cliente, empleado y sucursal válidos.';
            } else {
                $id = Venta::guardar(
                    $_POST['fecha'] ?? date('Y-m-d'),
                    $idCliente,
                    $idEmpleado,
                    $idSucursal
                );
                header("Location: index.php?controlador=venta&accion=detalle&id=" . $id);
                exit;
            }
        }

        require "views/venta_y_detalle/formulario.php";
    }

    public function comprar() {
        $productos = $this->productosParaVista();
        $clientes = Cliente::obtenerTodos();
        [$empleados, $sucursales] = $this->obtenerOpcionesVenta();
        $cantidades = [];
        $idClienteSeleccionado = '';
        $idEmpleadoSeleccionado = '';
        $idSucursalSeleccionada = '';
        $error = null;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $productosIngresados = is_array($_POST['productos'] ?? null) ? $_POST['productos'] : [];
            $idClienteSeleccionado = (string) ($_POST['id_cliente'] ?? '');
            $idEmpleadoSeleccionado = (string) ($_POST['id_empleado'] ?? '');
            $idSucursalSeleccionada = (string) ($_POST['id_sucursal'] ?? '');
            $idCliente = $idClienteSeleccionado === '' ? null : $this->idDesdePost('id_cliente');
            $idEmpleado = $this->idDesdePost('id_empleado');
            $idSucursal = $this->idDesdePost('id_sucursal');

            if (($idClienteSeleccionado !== '' && (!$idCliente || !$this->registroExiste('clientes', 'IdCliente', $idCliente))) ||
                !$idEmpleado || !$this->registroExiste('empleados', 'IdEmpleado', $idEmpleado) ||
                !$idSucursal || !$this->registroExiste('sucursales', 'IdSucursal', $idSucursal)) {
                $error = 'Selecciona un cliente, empleado y sucursal válidos.';
            }

            foreach ($productos as $idProducto => $producto) {
                $cantidadIngresada = $productosIngresados[$idProducto] ?? '0';
                $cantidades[$idProducto] = (is_string($cantidadIngresada) || is_int($cantidadIngresada))
                    ? (string) $cantidadIngresada
                    : '0';
            }

            $detalles = [];
            foreach ($productosIngresados as $idProductoIngresado => $cantidadIngresada) {
                $idProducto = filter_var((string) $idProductoIngresado, FILTER_VALIDATE_INT);
                if ($idProducto === false || !isset($productos[$idProducto]) ||
                    (!is_string($cantidadIngresada) && !is_int($cantidadIngresada))) {
                    $error = 'Verifica los productos y cantidades seleccionados.';
                    break;
                }
                $cantidad = filter_var($cantidadIngresada, FILTER_VALIDATE_INT);
                if ($cantidad === false || $cantidad < 0 || $cantidad > 1000) {
                    $error = 'Las cantidades deben estar entre 0 y 1000.';
                    break;
                }
                if ($cantidad > 0) {
                    $detalles[] = [
                        'id_producto' => $idProducto,
                        'cantidad' => $cantidad,
                        'precio' => $productos[$idProducto]['precio'],
                    ];
                }
            }

            if ($error === null && count($detalles) === 0) {
                $error = 'Agrega al menos un producto para continuar.';
            }

            if ($error === null) {
                try {
                    $idVenta = Venta::guardarConDetalles($idCliente, $idEmpleado, $idSucursal, $detalles);
                    header("Location: index.php?controlador=venta&accion=recibo&id=" . $idVenta);
                    exit;
                } catch (mysqli_sql_exception $exception) {
                    error_log('No fue posible registrar la compra: ' . $exception->getMessage());
                    $error = 'No se pudo guardar la compra. Revisa los datos e inténtalo de nuevo.';
                }
            }
        }

        require "views/venta_y_detalle/comprar.php";
    }

    public function recibo() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $venta = $id ? Venta::obtenerParaRecibo($id) : null;
        if (!$venta) {
            http_response_code(404);
            echo "La venta solicitada no existe.";
            return;
        }

        $detalles = DetalleVenta::obtenerPorVenta($id);
        require "views/venta_y_detalle/recibo.php";
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $venta = $id ? Venta::obtenerPorId($id) : null;
        if (!$venta) {
            http_response_code(404);
            echo "La venta solicitada no existe.";
            return;
        }

        [$empleados, $sucursales] = $this->obtenerOpcionesVenta();
        $clientes = Cliente::obtenerTodos();
        $error = null;
        $idClienteSeleccionado = (string) ($venta->IdCliente ?? '');
        $idEmpleadoSeleccionado = (string) $venta->IdEmpleado;
        $idSucursalSeleccionada = (string) $venta->IdSucursal;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $idClienteSeleccionado = (string) ($_POST['id_cliente'] ?? '');
            $idEmpleadoSeleccionado = (string) ($_POST['id_empleado'] ?? '');
            $idSucursalSeleccionada = (string) ($_POST['id_sucursal'] ?? '');
            $idCliente = $idClienteSeleccionado === '' ? null : $this->idDesdePost('id_cliente');
            $idEmpleado = $this->idDesdePost('id_empleado');
            $idSucursal = $this->idDesdePost('id_sucursal');

            if (($idClienteSeleccionado !== '' && (!$idCliente || !$this->registroExiste('clientes', 'IdCliente', $idCliente))) ||
                !$idEmpleado || !$this->registroExiste('empleados', 'IdEmpleado', $idEmpleado) ||
                !$idSucursal || !$this->registroExiste('sucursales', 'IdSucursal', $idSucursal)) {
                $error = 'Selecciona un cliente, empleado y sucursal válidos.';
            } else {
                Venta::actualizar(
                    $id,
                    $_POST['fecha'] ?? $venta->FechaVenta,
                    $idCliente,
                    $idEmpleado,
                    $idSucursal
                );
                header("Location: index.php?controlador=venta&accion=index");
                exit;
            }
        }

        require "views/venta_y_detalle/formulario.php";
    }

    public function eliminar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            Venta::eliminar($id);
        }
        header("Location: index.php?controlador=venta&accion=index");
        exit;
    }

    public function detalle() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $venta = $id ? Venta::obtenerPorId($id) : null;
        if (!$venta) {
            http_response_code(404);
            echo "La venta solicitada no existe.";
            return;
        }

        $cliente = $venta->IdCliente ? Cliente::obtenerPorId((int) $venta->IdCliente) : null;
        $productos = $this->productosParaVista();
        $detalles = DetalleVenta::obtenerPorVenta($id);
        require "views/venta_y_detalle/detalle.php";
    }

    public function agregarDetalle() {
        $idVenta = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
        $idProducto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
        $venta = $idVenta ? Venta::obtenerPorId($idVenta) : null;
        $producto = $idProducto ? Producto::obtenerPorId($idProducto) : null;

        if ($venta && $producto && $cantidad && $cantidad > 0) {
            DetalleVenta::guardar($idVenta, $idProducto, $cantidad, (float) $producto->Precio);
        } else {
            header("Location: index.php?controlador=venta&accion=detalle&id=" . (int) $idVenta . "&error=datos");
            exit;
        }
        header("Location: index.php?controlador=venta&accion=detalle&id=" . $idVenta);
        exit;
    }

    public function eliminarDetalle() {
        $idVenta = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $idDetalle = filter_input(INPUT_GET, 'id_detalle', FILTER_VALIDATE_INT);
        if ($idVenta && $idDetalle) {
            DetalleVenta::eliminar($idVenta, $idDetalle);
        }
        header("Location: index.php?controlador=venta&accion=detalle&id=" . (int) $idVenta);
        exit;
    }

    public function editarDetalle() {
        $idVenta = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $idDetalle = filter_input(INPUT_GET, 'id_detalle', FILTER_VALIDATE_INT);
        $venta = $idVenta ? Venta::obtenerPorId($idVenta) : null;
        $detalle = ($venta && $idDetalle) ? DetalleVenta::obtenerPorId($idVenta, $idDetalle) : null;
        if (!$venta || !$detalle) {
            http_response_code(404);
            echo "El detalle de venta solicitado no existe.";
            return;
        }

        $productos = $this->productosParaVista();
        $error = null;
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
            $idProducto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
            $producto = $idProducto ? Producto::obtenerPorId($idProducto) : null;
            if ($cantidad && $cantidad > 0 && $producto) {
                DetalleVenta::actualizar(
                    $idVenta,
                    $idDetalle,
                    $idProducto,
                    $cantidad,
                    (float) $producto->Precio
                );
                header("Location: index.php?controlador=venta&accion=detalle&id=" . $idVenta);
                exit;
            }
            $error = 'Selecciona un producto válido y una cantidad mayor que cero.';
        }

        require "views/venta_y_detalle/editar_detalle.php";
    }

    private function obtenerOpcionesVenta() {
        $db = Database::conectar();
        $empleados = $db->query("SELECT IdEmpleado, Nombre, Apellido FROM empleados ORDER BY Apellido, Nombre");
        $sucursales = $db->query("SELECT IdSucursal, Nombre FROM sucursales ORDER BY Nombre");
        return [$empleados, $sucursales];
    }

    private function productosParaVista() {
        $resultado = Producto::obtenerTodos();
        $productos = [];
        while ($producto = $resultado->fetch_object()) {
            $productos[(int) $producto->IdProducto] = [
                'nombre' => $producto->Nombre,
                'descripcion' => $producto->Descripcion,
                'precio' => (float) $producto->Precio,
                'existencias' => (int) $producto->Existencias,
            ];
        }
        return $productos;
    }

    private function registroExiste($tabla, $columnaId, $id) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT $columnaId FROM $tabla WHERE $columnaId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->num_rows > 0;
    }

    private function idDesdePost($campo) {
        $valor = $_POST[$campo] ?? null;
        if (!is_string($valor) && !is_int($valor)) {
            return null;
        }
        $id = filter_var($valor, FILTER_VALIDATE_INT);
        return $id && $id > 0 ? $id : null;
    }
}
