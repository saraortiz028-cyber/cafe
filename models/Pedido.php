<?php
require_once "config/database.php";

class Pedido
{
    // ==================================================
    // REGISTRAR PEDIDO DESDE EL CATÁLOGO PÚBLICO
    // ==================================================

    public static function crearConDetalles($idCliente, $idSucursal, $detalles)
    {
        $db = Database::conectar();
        $db->begin_transaction();

        try {
            $total = 0;

            foreach ($detalles as $detalle) {
                $total += $detalle['cantidad'] * $detalle['precio'];
            }

            $numeroTemporal = 'TEMP-' . bin2hex(random_bytes(8));

            $stmt = $db->prepare(
                "INSERT INTO pedido
                (NumeroPedido, Total, IdCliente, IdSucursal, EstadoPedido)
                VALUES (?, ?, ?, ?, 'Pendiente')"
            );

            $stmt->bind_param(
                "sdii",
                $numeroTemporal,
                $total,
                $idCliente,
                $idSucursal
            );

            $stmt->execute();

            $idPedido = $db->insert_id;

            $numeroPedido = 'PED-' . str_pad($idPedido, 5, '0', STR_PAD_LEFT);

            $stmt = $db->prepare(
                "UPDATE pedido SET NumeroPedido = ? WHERE IdPedido = ?"
            );

            $stmt->bind_param("si", $numeroPedido, $idPedido);
            $stmt->execute();

            $stmtDetalle = $db->prepare(
                "INSERT INTO detalle_pedido
                (Cantidad, PrecioUnitario, SubTotal, IdPedido, IdProducto)
                VALUES (?, ?, ?, ?, ?)"
            );

            foreach ($detalles as $detalle) {
                $cantidad = (int) $detalle['cantidad'];
                $precio = (float) $detalle['precio'];
                $subtotal = $cantidad * $precio;
                $idProducto = (int) $detalle['id_producto'];

                $stmtDetalle->bind_param(
                    "iddii",
                    $cantidad,
                    $precio,
                    $subtotal,
                    $idPedido,
                    $idProducto
                );

                $stmtDetalle->execute();
            }

            $db->commit();
            $db->close();

            return [
                'id' => $idPedido,
                'numero' => $numeroPedido
            ];

        } catch (Throwable $e) {
            $db->rollback();
            $db->close();
            throw $e;
        }
    }


    // ==================================================
    // OBTENER TODOS LOS PEDIDOS
    // ==================================================

    public static function obtenerTodos()
    {
        $db = Database::conectar();

        $resultado = $db->query(
            "SELECT *
             FROM pedido
             ORDER BY FechaPedido DESC, IdPedido DESC"
        );

        $db->close();

        return $resultado;
    }


    // ==================================================
    // OBTENER PEDIDO POR ID
    // ==================================================

    public static function obtenerPorId($idPedido)
    {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "SELECT *
             FROM pedido
             WHERE IdPedido = ?"
        );

        $stmt->bind_param("i", $idPedido);
        $stmt->execute();

        $pedido = $stmt->get_result()->fetch_object();

        $stmt->close();
        $db->close();

        return $pedido;
    }


    // ==================================================
    // OBTENER PEDIDO POR NÚMERO
    // ==================================================

    public static function obtenerPorNumero($numeroPedido)
    {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "SELECT *
             FROM pedido
             WHERE NumeroPedido = ?"
        );

        $stmt->bind_param("s", $numeroPedido);
        $stmt->execute();

        $pedido = $stmt->get_result()->fetch_object();

        $stmt->close();
        $db->close();

        return $pedido;
    }


    // ==================================================
    // OBTENER DETALLES DEL PEDIDO
    // ==================================================

    public static function obtenerDetalles($idPedido)
    {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "SELECT dp.*, p.Nombre AS NombreProducto
             FROM detalle_pedido dp
             INNER JOIN productos p
                ON dp.IdProducto = p.IdProducto
             WHERE dp.IdPedido = ?"
        );

        $stmt->bind_param("i", $idPedido);
        $stmt->execute();

        $detalles = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $db->close();

        return $detalles;
    }


    // ==================================================
    // APROBAR PEDIDO Y CONVERTIRLO EN VENTA
    // ==================================================

    public static function aprobar($idPedido, $idEmpleado)
    {
        $db = Database::conectar();
        $db->begin_transaction();

        try {

            // Bloquear el pedido para evitar procesarlo dos veces.
            $stmt = $db->prepare(
                "SELECT *
                 FROM pedido
                 WHERE IdPedido = ?
                 FOR UPDATE"
            );

            $stmt->bind_param("i", $idPedido);
            $stmt->execute();

            $pedido = $stmt->get_result()->fetch_object();

            if (!$pedido) {
                throw new Exception("El pedido no existe.");
            }

            if ($pedido->EstadoPedido !== 'Pendiente') {
                throw new Exception(
                    "Este pedido ya fue procesado anteriormente."
                );
            }

            // Obtener los productos solicitados.
            $stmtDetalles = $db->prepare(
                "SELECT IdProducto, Cantidad, PrecioUnitario
                 FROM detalle_pedido
                 WHERE IdPedido = ?"
            );

            $stmtDetalles->bind_param("i", $idPedido);
            $stmtDetalles->execute();

            $detalles = $stmtDetalles->get_result()->fetch_all(MYSQLI_ASSOC);

            if (empty($detalles)) {
                throw new Exception("El pedido no contiene productos.");
            }

            // Crear la venta.
            $fecha = date('Y-m-d');

            $stmtVenta = $db->prepare(
                "INSERT INTO ventas
                (FechaVenta, IdCliente, IdEmpleado, IdSucursal, Total)
                VALUES (?, ?, ?, ?, 0)"
            );

            $stmtVenta->bind_param(
                "siii",
                $fecha,
                $pedido->IdCliente,
                $idEmpleado,
                $pedido->IdSucursal
            );

            $stmtVenta->execute();

            $idVenta = $db->insert_id;

            // Preparar consultas de inventario y detalles.
            $stmtStock = $db->prepare(
                "SELECT Existencias
                 FROM productos
                 WHERE IdProducto = ?
                 FOR UPDATE"
            );

            $stmtDetalleVenta = $db->prepare(
                "INSERT INTO detalle_venta
                (IdVenta, IdProducto, Cantidad, PrecioUnitario, SubTotal)
                VALUES (?, ?, ?, ?, ?)"
            );

            $stmtActualizarStock = $db->prepare(
                "UPDATE productos
                 SET Existencias = Existencias - ?
                 WHERE IdProducto = ?
                 AND Existencias >= ?"
            );

            $total = 0;

            foreach ($detalles as $detalle) {

                $idProducto = (int) $detalle['IdProducto'];
                $cantidad = (int) $detalle['Cantidad'];
                $precio = (float) $detalle['PrecioUnitario'];

                if ($cantidad <= 0 || $precio < 0) {
                    throw new Exception(
                        "Los datos de un producto no son válidos."
                    );
                }

                // Consultar existencias.
                $stmtStock->bind_param("i", $idProducto);
                $stmtStock->execute();

                $producto = $stmtStock->get_result()->fetch_object();

                if (!$producto) {
                    throw new Exception(
                        "Uno de los productos del pedido ya no existe."
                    );
                }

                if ($producto->Existencias < $cantidad) {
                    throw new Exception(
                        "No hay existencias suficientes del producto "
                        . $idProducto . ". Disponibles: "
                        . $producto->Existencias
                        . ". Solicitadas: " . $cantidad . "."
                    );
                }

                $subtotal = $cantidad * $precio;
                $total += $subtotal;

                // Registrar detalle de venta.
                $stmtDetalleVenta->bind_param(
                    "iiidd",
                    $idVenta,
                    $idProducto,
                    $cantidad,
                    $precio,
                    $subtotal
                );

                $stmtDetalleVenta->execute();

                // Descontar existencias.
                $stmtActualizarStock->bind_param(
                    "iii",
                    $cantidad,
                    $idProducto,
                    $cantidad
                );

                $stmtActualizarStock->execute();

                if ($stmtActualizarStock->affected_rows !== 1) {
                    throw new Exception(
                        "No se pudieron actualizar las existencias."
                    );
                }
            }

            // Actualizar total de la venta.
            $stmtTotal = $db->prepare(
                "UPDATE ventas
                 SET Total = ?
                 WHERE IdVenta = ?"
            );

            $stmtTotal->bind_param("di", $total, $idVenta);
            $stmtTotal->execute();

            // Marcar el pedido como aprobado y vincular la venta.
            $stmtActualizarPedido = $db->prepare(
                "UPDATE pedido
                 SET EstadoPedido = 'Aprobado',
                     IdEmpleado = ?,
                     IdVenta = ?
                 WHERE IdPedido = ?
                 AND EstadoPedido = 'Pendiente'"
            );

            $stmtActualizarPedido->bind_param(
                "iii",
                $idEmpleado,
                $idVenta,
                $idPedido
            );

            $stmtActualizarPedido->execute();

            if ($stmtActualizarPedido->affected_rows !== 1) {
                throw new Exception(
                    "No se pudo actualizar el estado del pedido."
                );
            }

            // Confirmar todas las operaciones.
            $db->commit();
            $db->close();

            return $idVenta;

        } catch (Throwable $error) {

            $db->rollback();
            $db->close();

            throw $error;
        }
    }


    // ==================================================
    // RECHAZAR PEDIDO
    // ==================================================

    public static function rechazar($idPedido, $idEmpleado)
    {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "UPDATE pedido
             SET EstadoPedido = 'Rechazado',
                 IdEmpleado = ?
             WHERE IdPedido = ?
             AND EstadoPedido = 'Pendiente'"
        );

        $stmt->bind_param(
            "ii",
            $idEmpleado,
            $idPedido
        );

        $stmt->execute();

        $rechazado = $stmt->affected_rows === 1;

        $stmt->close();
        $db->close();

        if (!$rechazado) {
            throw new Exception(
                "El pedido no existe o ya fue procesado."
            );
        }

        return true;
    }
}