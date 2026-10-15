<?php
require_once "config/database.php";

class Venta {
    public static function obtenerTodos() {
        $db = Database::conectar();
        return $db->query("SELECT * FROM ventas ORDER BY FechaVenta DESC, IdVenta DESC");
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT * FROM ventas WHERE IdVenta = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function obtenerParaRecibo($id) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "SELECT v.*, c.Nombres AS ClienteNombres, c.Apellidos AS ClienteApellidos
             FROM ventas v
             LEFT JOIN clientes c ON c.IdCliente = v.IdCliente
             WHERE v.IdVenta = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($fecha, $idCliente, $idEmpleado, $idSucursal) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "INSERT INTO ventas (FechaVenta, IdCliente, IdEmpleado, IdSucursal, Total)
             VALUES (?, ?, ?, ?, 0)"
        );
        $stmt->bind_param("siii", $fecha, $idCliente, $idEmpleado, $idSucursal);
        $stmt->execute();
        return $db->insert_id;
    }

    public static function guardarConDetalles($idCliente, $idEmpleado, $idSucursal, array $detalles) {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $fecha = date('Y-m-d');
            $stmtVenta = $db->prepare(
                "INSERT INTO ventas (FechaVenta, IdCliente, IdEmpleado, IdSucursal, Total)
                 VALUES (?, ?, ?, ?, 0)"
            );
            $stmtVenta->bind_param("siii", $fecha, $idCliente, $idEmpleado, $idSucursal);
            $stmtVenta->execute();
            $idVenta = $db->insert_id;

            $stmtDetalle = $db->prepare(
                "INSERT INTO detalle_venta (IdVenta, IdProducto, Cantidad, PrecioUnitario, SubTotal)
                 VALUES (?, ?, ?, ?, ?)"
            );
            foreach ($detalles as $detalle) {
                $idProducto = $detalle['id_producto'];
                $cantidad = $detalle['cantidad'];
                $precio = $detalle['precio'];
                $subtotal = $cantidad * $precio;
                $stmtDetalle->bind_param("iiidd", $idVenta, $idProducto, $cantidad, $precio, $subtotal);
                $stmtDetalle->execute();
            }

            $stmtTotal = $db->prepare(
                "UPDATE ventas
                 SET Total = (SELECT COALESCE(SUM(SubTotal), 0)
                              FROM detalle_venta WHERE IdVenta = ?)
                 WHERE IdVenta = ?"
            );
            $stmtTotal->bind_param("ii", $idVenta, $idVenta);
            $stmtTotal->execute();
            $db->commit();
            $db->close();

            return $idVenta;
        } catch (Throwable $error) {
            $db->rollback();
            $db->close();
            throw $error;
        }
    }

    public static function actualizar($id, $fecha, $idCliente, $idEmpleado, $idSucursal) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "UPDATE ventas SET FechaVenta = ?, IdCliente = ?, IdEmpleado = ?, IdSucursal = ?
             WHERE IdVenta = ?"
        );
        $stmt->bind_param("siiii", $fecha, $idCliente, $idEmpleado, $idSucursal, $id);
        $stmt->execute();
    }

    public static function eliminar($id) {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $stmtDetalles = $db->prepare("DELETE FROM detalle_venta WHERE IdVenta = ?");
            $stmtDetalles->bind_param("i", $id);
            $stmtDetalles->execute();

            $stmtVenta = $db->prepare("DELETE FROM ventas WHERE IdVenta = ?");
            $stmtVenta->bind_param("i", $id);
            $stmtVenta->execute();
            $db->commit();
        } catch (Throwable $error) {
            $db->rollback();
            throw $error;
        }
    }
}
