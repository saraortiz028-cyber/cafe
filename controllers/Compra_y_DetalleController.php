<?php
require_once "models/Compra.php";
require_once "models/DetalleCompra.php";
require_once "models/Productos.php";
require_once "models/Proveedor.php";
require_once "models/Sucursal.php";

class CompraController {
    public function index() {
        $compras = Compra::obtenerTodos();
        require "views/compras_y_detalle/index.php";
    }

    public function crear() {
        $proveedores = Proveedor::obtenerTodos();
        $sucursales = Sucursal::obtenerTodos();
        $proveedorSeleccionado = '';
        $sucursalSeleccionada = '';
        $error = null;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $proveedorSeleccionado = (string) ($_POST['id_proveedor'] ?? '');
            $sucursalSeleccionada = (string) ($_POST['id_sucursal'] ?? '');
            $idProveedor = $this->idDesdePost('id_proveedor');
            $idSucursal = $this->idDesdePost('id_sucursal');

            if (!$idProveedor || !$this->registroExiste('proveedores', 'IdProveedor', $idProveedor) ||
                !$idSucursal || !$this->registroExiste('sucursales', 'IdSucursal', $idSucursal)) {
                $error = 'Selecciona un proveedor y una sucursal válidos.';
            } else {
                $id = Compra::guardar($_POST['fecha'] ?? date('Y-m-d'), $idProveedor, $idSucursal);
                header("Location: index.php?controlador=compra&accion=detalle&id=" . $id);
                exit;
            }
        }

        $compra = null;
        require "views/compras_y_detalle/formulario.php";
    }

    public function editar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $compra = $id ? Compra::obtenerPorId($id) : null;
        if (!$compra) {
            http_response_code(404);
            echo "La compra solicitada no existe.";
            return;
        }

        $proveedores = Proveedor::obtenerTodos();
        $sucursales = Sucursal::obtenerTodos();
        $proveedorSeleccionado = (string) $compra->IdProveedor;
        $sucursalSeleccionada = (string) $compra->IdSucursal;
        $error = null;

        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $proveedorSeleccionado = (string) ($_POST['id_proveedor'] ?? '');
            $sucursalSeleccionada = (string) ($_POST['id_sucursal'] ?? '');
            $idProveedor = $this->idDesdePost('id_proveedor');
            $idSucursal = $this->idDesdePost('id_sucursal');

            if (!$idProveedor || !$this->registroExiste('proveedores', 'IdProveedor', $idProveedor) ||
                !$idSucursal || !$this->registroExiste('sucursales', 'IdSucursal', $idSucursal)) {
                $error = 'Selecciona un proveedor y una sucursal válidos.';
            } else {
                Compra::actualizar(
                    $id,
                    $_POST['fecha'] ?? $compra->FechaCompra,
                    $idProveedor,
                    $idSucursal
                );
                header("Location: index.php?controlador=compra&accion=index");
                exit;
            }
        }
        require "views/compras_y_detalle/formulario.php";
    }

    public function eliminar() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            Compra::eliminar($id);
        }
        header("Location: index.php?controlador=compra&accion=index");
        exit;
    }

    public function detalle() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $compra = $id ? Compra::obtenerPorId($id) : null;
        if (!$compra) {
            http_response_code(404);
            echo "La compra solicitada no existe.";
            return;
        }
        $productos = $this->productosParaVista();
        $detalles = DetalleCompra::obtenerPorCompra($id);
        require "views/compras_y_detalle/detalle.php";
    }

    public function agregarDetalle() {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
        $idProducto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
        $precio = filter_input(INPUT_POST, 'precio_unitario', FILTER_VALIDATE_FLOAT);
        $compra = $id ? Compra::obtenerPorId($id) : null;
        $producto = $idProducto ? Producto::obtenerPorId($idProducto) : null;

        if ($compra && $producto && $cantidad && $cantidad > 0 && $precio !== null && $precio !== false && $precio >= 0) {
            DetalleCompra::guardar($id, $idProducto, $cantidad, $precio);
        } else {
            header("Location: index.php?controlador=compra&accion=detalle&id=" . (int) $id . "&error=datos");
            exit;
        }
        header("Location: index.php?controlador=compra&accion=detalle&id=" . (int) $id);
        exit;
    }

    public function eliminarDetalle() {
        $idCompra = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $idDetalle = filter_input(INPUT_GET, 'id_detalle', FILTER_VALIDATE_INT);
        if ($idCompra && $idDetalle) {
            DetalleCompra::eliminar($idCompra, $idDetalle);
        }
        header("Location: index.php?controlador=compra&accion=detalle&id=" . (int) $idCompra);
        exit;
    }

    public function editarDetalle() {
        $idCompra = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $idDetalle = filter_input(INPUT_GET, 'id_detalle', FILTER_VALIDATE_INT);
        $compra = $idCompra ? Compra::obtenerPorId($idCompra) : null;
        $detalle = ($compra && $idDetalle) ? DetalleCompra::obtenerPorId($idCompra, $idDetalle) : null;

        if (!$compra || !$detalle) {
            http_response_code(404);
            echo "El detalle de compra solicitado no existe.";
            return;
        }

        $productos = $this->productosParaVista();
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT);
            $precio = filter_input(INPUT_POST, 'precio_unitario', FILTER_VALIDATE_FLOAT);
            $idProducto = filter_input(INPUT_POST, 'id_producto', FILTER_VALIDATE_INT);
            $producto = $idProducto ? Producto::obtenerPorId($idProducto) : null;

            if ($producto && $cantidad && $cantidad > 0 && $precio !== null && $precio !== false && $precio >= 0) {
                DetalleCompra::actualizar($idCompra, $idDetalle, $idProducto, $cantidad, $precio);
                header("Location: index.php?controlador=compra&accion=detalle&id=" . $idCompra);
                exit;
            }

            $error = "Selecciona un producto válido y verifica la cantidad y el precio.";
        }

        require "views/compras_y_detalle/editar_detalle.php";
    }

    private function productosParaVista() {
        $resultado = Producto::obtenerTodos();
        $productos = [];
        while ($producto = $resultado->fetch_object()) {
            $productos[(int) $producto->IdProducto] = [
                'nombre' => $producto->Nombre,
                'precio' => (float) $producto->Precio,
            ];
        }
        return $productos;
    }

    private function registroExiste($tabla, $columna, $id) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT $columna FROM $tabla WHERE $columna = ?");
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
