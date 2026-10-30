<?php

require_once "config/database.php";

class Home
{
    /**
     * Obtiene las estadísticas generales del negocio.
     * Compara los mismos días transcurridos de ambas semanas.
     */
    public static function obtenerEstadisticas()
    {
        $db = Database::conectar();

        // Inicio de la semana actual: lunes.
        $inicioActual = new DateTime('monday this week');
        $inicioActual->setTime(0, 0, 0);

        // Final del período actual: mañana, sin incluirla.
        $finActual = new DateTime('tomorrow');
        $finActual->setTime(0, 0, 0);

        // Período equivalente de la semana anterior.
        $inicioAnterior = clone $inicioActual;
        $inicioAnterior->modify('-7 days');

        $finAnterior = clone $finActual;
        $finAnterior->modify('-7 days');

        // Formato para las consultas SQL.
        $inicioActualSQL = $inicioActual->format('Y-m-d');
        $finActualSQL = $finActual->format('Y-m-d');

        $inicioAnteriorSQL = $inicioAnterior->format('Y-m-d');
        $finAnteriorSQL = $finAnterior->format('Y-m-d');

        $estadisticas = [];

                /*
         * VENTAS
         *
         * Compara las ventas de los mismos días
         * de la semana actual y la anterior.
         */

        $sqlVentas = "
            SELECT
                COALESCE(
                    SUM(
                        CASE
                            WHEN FechaVenta >= ?
                             AND FechaVenta < ?
                            THEN 1
                            ELSE 0
                        END
                    ), 0
                ) AS ventas_actuales,

                COALESCE(
                    SUM(
                        CASE
                            WHEN FechaVenta >= ?
                             AND FechaVenta < ?
                            THEN 1
                            ELSE 0
                        END
                    ), 0
                ) AS ventas_anteriores

            FROM ventas
        ";

        $stmt = $db->prepare($sqlVentas);

        $stmt->bind_param(
            "ssss",
            $inicioActualSQL,
            $finActualSQL,
            $inicioAnteriorSQL,
            $finAnteriorSQL
        );

        $stmt->execute();

        $ventas = $stmt->get_result()->fetch_assoc();

        $estadisticas['ventas_semana'] =
            (int) $ventas['ventas_actuales'];

        $estadisticas['ventas_semana_anterior'] =
            (int) $ventas['ventas_anteriores'];

        $estadisticas['variacion_ventas'] =
            self::calcularVariacion(
                $estadisticas['ventas_semana'],
                $estadisticas['ventas_semana_anterior']
            );

                /*
         * CLIENTES
         *
         * El total de clientes es acumulado.
         * La comparación considera los clientes
         * registrados durante cada período.
         */

        $sqlClientes = "
            SELECT
                COUNT(*) AS total_clientes,

                COALESCE(
                    SUM(
                        CASE
                            WHEN FechaRegistro >= ?
                             AND FechaRegistro < ?
                            THEN 1
                            ELSE 0
                        END
                    ), 0
                ) AS clientes_actuales,

                COALESCE(
                    SUM(
                        CASE
                            WHEN FechaRegistro >= ?
                             AND FechaRegistro < ?
                            THEN 1
                            ELSE 0
                        END
                    ), 0
                ) AS clientes_anteriores

            FROM clientes
        ";

        $stmt = $db->prepare($sqlClientes);

        $stmt->bind_param(
            "ssss",
            $inicioActualSQL,
            $finActualSQL,
            $inicioAnteriorSQL,
            $finAnteriorSQL
        );

        $stmt->execute();

        $clientes = $stmt->get_result()->fetch_assoc();

        $estadisticas['total_clientes'] =
            (int) $clientes['total_clientes'];

        $estadisticas['clientes_semana'] =
            (int) $clientes['clientes_actuales'];

        $estadisticas['clientes_semana_anterior'] =
            (int) $clientes['clientes_anteriores'];

        $estadisticas['variacion_clientes'] =
            self::calcularVariacion(
                $estadisticas['clientes_semana'],
                $estadisticas['clientes_semana_anterior']
            );

                /*
         * COMPRAS
         *
         * Compara la cantidad de compras realizadas
         * durante ambos períodos.
         */

        $sqlCompras = "
            SELECT
                COALESCE(
                    SUM(
                        CASE
                            WHEN FechaCompra >= ?
                             AND FechaCompra < ?
                            THEN 1
                            ELSE 0
                        END
                    ), 0
                ) AS compras_actuales,

                COALESCE(
                    SUM(
                        CASE
                            WHEN FechaCompra >= ?
                             AND FechaCompra < ?
                            THEN 1
                            ELSE 0
                        END
                    ), 0
                ) AS compras_anteriores

            FROM compras
        ";

        $stmt = $db->prepare($sqlCompras);

        $stmt->bind_param(
            "ssss",
            $inicioActualSQL,
            $finActualSQL,
            $inicioAnteriorSQL,
            $finAnteriorSQL
        );

        $stmt->execute();

        $compras = $stmt->get_result()->fetch_assoc();

        $estadisticas['compras_semana'] =
            (int) $compras['compras_actuales'];

        $estadisticas['compras_semana_anterior'] =
            (int) $compras['compras_anteriores'];

        $estadisticas['variacion_compras'] =
            self::calcularVariacion(
                $estadisticas['compras_semana'],
                $estadisticas['compras_semana_anterior']
            );


                /*
         * FECHAS DE COMPARACIÓN
         *
         * Se envían a la vista para informar
         * qué períodos se están comparando.
         */

        $finActualMostrar = clone $finActual;
        $finActualMostrar->modify('-1 day');

        $finAnteriorMostrar = clone $finAnterior;
        $finAnteriorMostrar->modify('-1 day');

        $estadisticas['periodo_actual'] =
            $inicioActual->format('d/m/Y') .
            ' - ' .
            $finActualMostrar->format('d/m/Y');

        $estadisticas['periodo_anterior'] =
            $inicioAnterior->format('d/m/Y') .
            ' - ' .
            $finAnteriorMostrar->format('d/m/Y');

        $stmt->close();
        $db->close();

        return $estadisticas;
    }


        /**
     * Obtiene los cinco productos más vendidos
     * desde el inicio del historial de ventas.
     */
    public static function obtenerProductosMasVendidos()
    {
        $db = Database::conectar();

        $sql = "
            SELECT
                p.IdProducto,
                p.Nombre,
                p.Imagen,
                SUM(dv.Cantidad) AS unidades_vendidas

            FROM detalle_venta dv

            INNER JOIN ventas v
                ON v.IdVenta = dv.IdVenta

            INNER JOIN productos p
                ON p.IdProducto = dv.IdProducto

            GROUP BY
                p.IdProducto,
                p.Nombre,
                p.Imagen

            ORDER BY
                unidades_vendidas DESC,
                p.Nombre ASC

            LIMIT 5
        ";

        $stmt = $db->prepare($sql);

        $stmt->execute();

        $resultado = $stmt->get_result();

        $productos = [];

        while ($fila = $resultado->fetch_assoc()) {
            $productos[] = $fila;
        }

        $stmt->close();
        $db->close();

        return $productos;
    }

        /**
     * Calcula la variación porcentual entre dos períodos.
     */
    private static function calcularVariacion($actual, $anterior)
    {
        if ((float) $anterior == 0.0) {

            if ((float) $actual == 0.0) {
                return [
                    'porcentaje' => 0,
                    'tipo' => 'igual',
                    'texto' => 'Sin cambios'
                ];
            }

            return [
                'porcentaje' => null,
                'tipo' => 'nuevo',
                'texto' => 'Sin registros en el período anterior'
            ];
        }

        $porcentaje = (
            ($actual - $anterior) / $anterior
        ) * 100;

        if ($porcentaje > 0) {

            $tipo = 'subida';

            $texto = 'Aumento del ' .
                number_format($porcentaje, 1) . '%';

        } elseif ($porcentaje < 0) {

            $tipo = 'bajada';

            $texto = 'Disminución del ' .
                number_format(abs($porcentaje), 1) . '%';

        } else {

            $tipo = 'igual';

            $texto = 'Sin cambios';
        }

        return [
            'porcentaje' => round($porcentaje, 1),
            'tipo' => $tipo,
            'texto' => $texto
        ];
    }
}