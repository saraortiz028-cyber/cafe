<?php
require_once "config/database.php";

class DetalleVenta {
    public static function obtenerPorVenta($idVenta) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "SELECT d.*, p.Nombre AS NombreProducto
             FROM detalle_venta d
             JOIN productos p ON p.IdProducto = d.IdProducto
             WHERE d.IdVenta = ?
             ORDER BY d.IdDetalleVenta"
        );
        $stmt->bind_param("i", $idVenta);
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function obtenerPorId($idVenta, $idDetalle) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "SELECT d.*, p.Nombre AS NombreProducto
             FROM detalle_venta d
             JOIN productos p ON p.IdProducto = d.IdProducto
             WHERE d.IdVenta = ? AND d.IdDetalleVenta = ?"
        );
        $stmt->bind_param("ii", $idVenta, $idDetalle);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($idVenta, $idProducto, $cantidad, $precioUnitario) {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $stmt = $db->prepare(
                 "INSERT INTO detalle_venta (IdVenta, IdProducto, Cantidad, PrecioUnitario, SubTotal)
                  VALUES (?, ?, ?, ?, ?)"
            );
              $subtotal = $cantidad * $precioUnitario;
              $stmt->bind_param("iiidd", $idVenta, $idProducto, $cantidad, $precioUnitario, $subtotal);
            $stmt->execute();

            $stmtStock = $db->prepare("UPDATE productos SET Existencias = Existencias - ? WHERE IdProducto = ?");
            $stmtStock->bind_param("ii", $cantidad, $idProducto);
            $stmtStock->execute();

            self::actualizarTotal($db, $idVenta);
            $db->commit();
        } catch (Throwable $error) {
            $db->rollback();
            throw $error;
        }
    }

    public static function actualizar($idVenta, $idDetalle, $idProducto, $cantidad, $precioUnitario) {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $subtotal = $cantidad * $precioUnitario;

            $stmt = $db->prepare(
                 "UPDATE detalle_venta
                  SET IdProducto = ?, Cantidad = ?, PrecioUnitario = ?, SubTotal = ?
                 WHERE IdVenta = ? AND IdDetalleVenta = ?"
            );
            
            // se cambio "iidiii" por "iiddii" para evitar problemas con el subtotal
            $stmt->bind_param("iiddii", $idProducto, $cantidad, $precioUnitario, $subtotal, $idVenta, $idDetalle);
            $stmt->execute();
            self::actualizarTotal($db, $idVenta);
            $db->commit();
        } catch (Throwable $error) {
            $db->rollback();
            throw $error;
        }
    }

    public static function eliminar($idVenta, $idDetalle) {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $stmt = $db->prepare(
                "DELETE FROM detalle_venta WHERE IdDetalleVenta = ? AND IdVenta = ?"
            );
            $stmt->bind_param("ii", $idDetalle, $idVenta);
            $stmt->execute();
            self::actualizarTotal($db, $idVenta);
            $db->commit();
        } catch (Throwable $error) {
            $db->rollback();
            throw $error;
        }
    }

    private static function actualizarTotal($db, $idVenta) {
        $stmt = $db->prepare(
            "UPDATE ventas
             SET Total = (SELECT COALESCE(SUM(SubTotal), 0)
                          FROM detalle_venta WHERE IdVenta = ?)
             WHERE IdVenta = ?"
        );
        $stmt->bind_param("ii", $idVenta, $idVenta);
        $stmt->execute();
    }
}
