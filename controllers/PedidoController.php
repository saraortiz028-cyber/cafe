<?php

require_once "models/Pedido.php";
require_once "models/Venta.php";
require_once "models/DetalleVenta.php";
require_once "auth.php";

class PedidoController
{
    // ==================================================
    // LISTADO DE PEDIDOS
    // ==================================================

    public function index(): void
    {
        $pedidos = Pedido::obtenerTodos();

        require "views/pedidos/index.php";
    }


    // ==================================================
    // DETALLE DE UN PEDIDO
    // ==================================================

    public function detalle(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id || $id <= 0) {
            http_response_code(400);
            exit("Identificador de pedido no válido.");
        }

        $pedido = Pedido::obtenerPorId($id);

        if (!$pedido) {
            http_response_code(404);
            exit("El pedido solicitado no existe.");
        }

        $detalles = Pedido::obtenerDetalles($id);

        require "views/pedidos/detalle.php";
    }


    // ==================================================
    // APROBAR PEDIDO
    // ==================================================

    public function aprobar(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            exit("Método no permitido.");
        }

        if (!Auth::validarCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            exit("Solicitud no válida. Actualiza la página e inténtalo nuevamente.");
        }

        $idPedido = filter_input(
            INPUT_POST,
            'idPedido',
            FILTER_VALIDATE_INT
        );

        if (!$idPedido || $idPedido <= 0) {
            $_SESSION['error_pedido'] = "El identificador del pedido no es válido.";

            header("Location: index.php?controlador=pedido&accion=index");
            exit;
        }

        $idEmpleado = (int) $_SESSION['empleado']['IdEmpleado'];

        try {

            $idVenta = Pedido::aprobar($idPedido, $idEmpleado);

            // Redirigir al recibo indicando que viene de aprobar un pedido.
            header(
                "Location: index.php?controlador=publico&accion=recibo&id="
                . $idVenta . "&origen=pedido"
                );
            exit;

        } catch (Throwable $error) {

            error_log(
                "Error al aprobar pedido: " . $error->getMessage()
            );

            $_SESSION['error_pedido'] = $error->getMessage();

            header(
                "Location: index.php?controlador=pedido&accion=detalle&id="
                . $idPedido
            );
            exit;
        }
    }


    // ==================================================
    // RECHAZAR PEDIDO
    // ==================================================

    public function rechazar(): void
    {
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
            http_response_code(405);
            exit("Método no permitido.");
        }

        if (!Auth::validarCsrf($_POST['csrf_token'] ?? null)) {
            http_response_code(403);
            exit("Solicitud no válida. Actualiza la página e inténtalo nuevamente.");
        }

        $idPedido = filter_input(
            INPUT_POST,
            'idPedido',
            FILTER_VALIDATE_INT
        );

        if (!$idPedido || $idPedido <= 0) {
            $_SESSION['error_pedido'] = "El identificador del pedido no es válido.";

            header("Location: index.php?controlador=pedido&accion=index");
            exit;
        }

        $idEmpleado = (int) $_SESSION['empleado']['IdEmpleado'];

        try {

            Pedido::rechazar($idPedido, $idEmpleado);

            $_SESSION['mensaje_pedido'] = "El pedido fue rechazado correctamente.";

        } catch (Throwable $error) {

            error_log(
                "Error al rechazar pedido: " . $error->getMessage()
            );

            $_SESSION['error_pedido'] = $error->getMessage();
        }

        header(
            "Location: index.php?controlador=pedido&accion=detalle&id="
            . $idPedido
        );
        exit;
    }
}