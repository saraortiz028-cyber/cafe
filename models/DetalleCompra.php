<?php
require_once "config/database.php";

class DetalleCompra {
    public static function obtenerPorCompra($idCompra) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "SELECT d.*, p.Nombre AS NombreProducto
             FROM detalle_compra d
             JOIN productos p ON p.IdProducto = d.IdProducto
             WHERE d.IdCompra = ?
             ORDER BY d.IdDetalleCompra"
        );
        $stmt->bind_param("i", $idCompra);
        $stmt->execute();
        return $stmt->get_result();
    }

    public static function obtenerPorId($idCompra, $idDetalle) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "SELECT d.*, p.Nombre AS NombreProducto
             FROM detalle_compra d
             JOIN productos p ON p.IdProducto = d.IdProducto
             WHERE d.IdCompra = ? AND d.IdDetalleCompra = ?"
        );
        $stmt->bind_param("ii", $idCompra, $idDetalle);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($idCompra, $idProducto, $cantidad, $precioUnitario) {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $stmt = $db->prepare(
                 "INSERT INTO detalle_compra (IdCompra, IdProducto, Cantidad, PrecioUnitario, SubTotal)
                  VALUES (?, ?, ?, ?, ?)"
            );
              $subtotal = $cantidad * $precioUnitario;
              $stmt->bind_param("iiidd", $idCompra, $idProducto, $cantidad, $precioUnitario, $subtotal);
            $stmt->execute();
            self::actualizarTotal($db, $idCompra);
            $db->commit();
        } catch (Throwable $error) {
            $db->rollback();
            throw $error;
        }
    }

    public static function actualizar($idCompra, $idDetalle, $idProducto, $cantidad, $precioUnitario) {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $stmt = $db->prepare(
                "UPDATE detalle_compra
                                 SET IdProducto = ?, Cantidad = ?, PrecioUnitario = ?, SubTotal = ?
                 WHERE IdCompra = ? AND IdDetalleCompra = ?"
            );
                        $subtotal = $cantidad * $precioUnitario;
                        $stmt->bind_param("iiddii", $idProducto, $cantidad, $precioUnitario, $subtotal, $idCompra, $idDetalle);
            $stmt->execute();
            self::actualizarTotal($db, $idCompra);
            $db->commit();
        } catch (Throwable $error) {
            $db->rollback();
            throw $error;
        }
    }

    public static function eliminar($idCompra, $idDetalle) {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $stmt = $db->prepare(
                "DELETE FROM detalle_compra WHERE IdDetalleCompra = ? AND IdCompra = ?"
            );
            $stmt->bind_param("ii", $idDetalle, $idCompra);
            $stmt->execute();
            self::actualizarTotal($db, $idCompra);
            $db->commit();
        } catch (Throwable $error) {
            $db->rollback();
            throw $error;
        }
    }

    private static function actualizarTotal($db, $idCompra) {
        $stmt = $db->prepare(
            "UPDATE compras
             SET Total = (SELECT COALESCE(SUM(SubTotal), 0)
                          FROM detalle_compra WHERE IdCompra = ?)
             WHERE IdCompra = ?"
        );
        $stmt->bind_param("ii", $idCompra, $idCompra);
        $stmt->execute();
    }
}
