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
        if (empty($detalles)) {
            throw new Exception("La venta debe contener al menos un producto.");
        }

        $fecha = date('Y-m-d');

        // Crear la venta
        $stmtVenta = $db->prepare(
            "INSERT INTO ventas (FechaVenta, IdCliente, IdEmpleado, IdSucursal, Total)
             VALUES (?, ?, ?, ?, 0)"
        );

        $stmtVenta->bind_param(
            "siii",
            $fecha,
            $idCliente,
            $idEmpleado,
            $idSucursal
        );

        $stmtVenta->execute();
        $idVenta = $db->insert_id;

        // Preparar las consultas
        $stmtStock = $db->prepare(
            "SELECT Existencias
             FROM productos
             WHERE IdProducto = ?
             FOR UPDATE"
        );

        $stmtDetalle = $db->prepare(
            "INSERT INTO detalle_venta
             (IdVenta, IdProducto, Cantidad, PrecioUnitario, SubTotal)
             VALUES (?, ?, ?, ?, ?)"
        );

        $stmtActualizarStock = $db->prepare(
            "UPDATE productos
             SET Existencias = Existencias - ?
             WHERE IdProducto = ? AND Existencias >= ?"
        );

        // Registrar los detalles y descontar existencias
        foreach ($detalles as $detalle) {
            $idProducto = (int) $detalle['id_producto'];
            $cantidad = (int) $detalle['cantidad'];
            $precio = (float) $detalle['precio'];

            if ($idProducto <= 0 || $cantidad <= 0 || $precio < 0) {
                throw new Exception("Los datos de un producto no son válidos.");
            }

            // Consultar y bloquear las existencias del producto
            $stmtStock->bind_param("i", $idProducto);
            $stmtStock->execute();

            $resultadoStock = $stmtStock->get_result();
            $producto = $resultadoStock->fetch_object();

            if (!$producto) {
                throw new Exception("Uno de los productos no existe.");
            }

            if ($producto->Existencias < $cantidad) {
                throw new Exception(
                    "No hay existencias suficientes del producto ID "
                    . $idProducto . ". Disponibles: "
                    . $producto->Existencias . ". Solicitadas: "
                    . $cantidad . "."
                );
            }

            $subtotal = $cantidad * $precio;

            // Guardar el detalle de la venta
            $stmtDetalle->bind_param(
                "iiidd",
                $idVenta,
                $idProducto,
                $cantidad,
                $precio,
                $subtotal
            );

            $stmtDetalle->execute();

            // Descontar las unidades vendidas
            $stmtActualizarStock->bind_param(
                "iii",
                $cantidad,
                $idProducto,
                $cantidad
            );

            $stmtActualizarStock->execute();

            if ($stmtActualizarStock->affected_rows !== 1) {
                throw new Exception(
                    "No se pudieron actualizar las existencias del producto ID "
                    . $idProducto . "."
                );
            }
        }

        // Calcular el total de la venta
        $stmtTotal = $db->prepare(
            "UPDATE ventas
             SET Total = (
                 SELECT COALESCE(SUM(SubTotal), 0)
                 FROM detalle_venta
                 WHERE IdVenta = ?
             )
             WHERE IdVenta = ?"
        );

        $stmtTotal->bind_param("ii", $idVenta, $idVenta);
        $stmtTotal->execute();

        // Confirmar todos los cambios
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
