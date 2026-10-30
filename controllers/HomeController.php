<?php

require_once "models/Home.php";

class HomeController
{
    public function index()
    {
        $estadisticas = Home::obtenerEstadisticas();

        $productosMasVendidos =
            Home::obtenerProductosMasVendidos();

        require "views/admin/home.php";
    }

    /**
     * Devuelve las estadísticas en JSON para JavaScript.
     */
    public function estadisticas()
    {
       /* $estadisticas = Home::obtenerEstadisticas();

    echo '<pre>';
    print_r($estadisticas);
    echo '</pre>';
    exit;*/

        header('Content-Type: application/json; charset=utf-8');

        try {
            $estadisticas = Home::obtenerEstadisticas();

            $productosMasVendidos =
                Home::obtenerProductosMasVendidos();

            echo json_encode([
                'ok' => true,
                'estadisticas' => $estadisticas,
                'productos' => $productosMasVendidos
            ], JSON_UNESCAPED_UNICODE);

        } catch (Throwable $error) {
            http_response_code(500);

            echo json_encode([
                'ok' => false,
                'mensaje' => 'No se pudieron actualizar las estadísticas.'
            ], JSON_UNESCAPED_UNICODE);
        }

        exit;
    }
}