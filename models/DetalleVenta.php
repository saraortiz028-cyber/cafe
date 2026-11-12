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

    // Obtener el subtotal de los productos.
    $stmtSubtotal = $db->prepare(
        "SELECT COALESCE(SUM(SubTotal), 0) AS Subtotal
         FROM detalle_venta
         WHERE IdVenta = ?"
    );

    $stmtSubtotal->bind_param("i", $idVenta);
    $stmtSubtotal->execute();

    $resultado = $stmtSubtotal->get_result()->fetch_object();

    $subtotal = (float) $resultado->Subtotal;

    // Obtener la tasa de IVA guardada en la venta.
    $stmtIVA = $db->prepare(
        "SELECT TasaIVA
         FROM ventas
         WHERE IdVenta = ?"
    );

    $stmtIVA->bind_param("i", $idVenta);
    $stmtIVA->execute();

    $venta = $stmtIVA->get_result()->fetch_object();

    if (!$venta) {
        throw new Exception("No se encontró la venta.");
    }

    $tasaIVA = (float) $venta->TasaIVA;

    // Calcular IVA y total.
    $iva = round($subtotal * ($tasaIVA / 100), 2);

    $total = $subtotal + $iva;

    // Actualizar los valores de la venta.
    $stmtActualizar = $db->prepare(
        "UPDATE ventas
         SET IVA = ?, Total = ?
         WHERE IdVenta = ?"
    );

    $stmtActualizar->bind_param(
        "ddi",
        $iva,
        $total,
        $idVenta
    );

    $stmtActualizar->execute();
}
}
