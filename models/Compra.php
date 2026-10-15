<?php
require_once "config/database.php";

class Compra {
    public static function obtenerTodos() {
        $db = Database::conectar();
        return $db->query(
            "SELECT c.*, p.Nombre AS NombreProveedor, s.Nombre AS NombreSucursal
             FROM compras c
             JOIN proveedores p ON p.IdProveedor = c.IdProveedor
             JOIN sucursales s ON s.IdSucursal = c.IdSucursal
             ORDER BY c.FechaCompra DESC, c.IdCompra DESC"
        );
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "SELECT c.*, p.Nombre AS NombreProveedor, s.Nombre AS NombreSucursal
             FROM compras c
             JOIN proveedores p ON p.IdProveedor = c.IdProveedor
             JOIN sucursales s ON s.IdSucursal = c.IdSucursal
             WHERE c.IdCompra = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($fecha, $idProveedor, $idSucursal) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "INSERT INTO compras (FechaCompra, IdSucursal, IdProveedor, Total)
             VALUES (?, ?, ?, 0)"
        );
        $stmt->bind_param("sii", $fecha, $idSucursal, $idProveedor);
        $stmt->execute();
        return $db->insert_id;
    }

    public static function actualizar($id, $fecha, $idProveedor, $idSucursal) {
        $db = Database::conectar();
        $stmt = $db->prepare(
            "UPDATE compras SET FechaCompra = ?, IdProveedor = ?, IdSucursal = ?
             WHERE IdCompra = ?"
        );
        $stmt->bind_param("siii", $fecha, $idProveedor, $idSucursal, $id);
        $stmt->execute();
    }

    public static function eliminar($id) {
        $db = Database::conectar();
        $db->begin_transaction();
        try {
            $stmtDetalles = $db->prepare("DELETE FROM detalle_compra WHERE IdCompra = ?");
            $stmtDetalles->bind_param("i", $id);
            $stmtDetalles->execute();

            $stmtCompra = $db->prepare("DELETE FROM compras WHERE IdCompra = ?");
            $stmtCompra->bind_param("i", $id);
            $stmtCompra->execute();
            $db->commit();
        } catch (Throwable $error) {
            $db->rollback();
            throw $error;
        }
    }
}
