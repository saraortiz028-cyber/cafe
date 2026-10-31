<?php
require_once "config/database.php";

class Producto {

    public static function obtenerTodos() {
        $db = Database::conectar();

        return $db->query(
            "SELECT p.*, c.Nombre AS NombreCategoria
             FROM productos p
             LEFT JOIN categorias c ON p.IdCategoria = c.IdCategoria"
        );
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "SELECT * FROM productos WHERE IdProducto = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        return $stmt->get_result()->fetch_object();
    }

    // Registrar producto incluyendo su imagen.
    public static function guardar(
        $nombre,
        $descripcion,
        $precio,
        $existencias,
        $idCategoria = null,
        $imagen = null
    ) {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "INSERT INTO productos
            (Nombre, Descripcion, Precio, Existencias, IdCategoria, Imagen)
            VALUES (?, ?, ?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssdiis",
            $nombre,
            $descripcion,
            $precio,
            $existencias,
            $idCategoria,
            $imagen
        );

        $stmt->execute();
        $stmt->close();
    }

    // Actualizar producto y su imagen.
    public static function actualizar(
        $id,
        $nombre,
        $descripcion,
        $precio,
        $existencias,
        $idCategoria = null,
        $imagen = null
    ) {
        $db = Database::conectar();

        $stmt = $db->prepare(
            "UPDATE productos
             SET Nombre = ?,
                 Descripcion = ?,
                 Precio = ?,
                 Existencias = ?,
                 IdCategoria = ?,
                 Imagen = ?
             WHERE IdProducto = ?"
        );

        $stmt->bind_param(
            "ssdiisi",
            $nombre,
            $descripcion,
            $precio,
            $existencias,
            $idCategoria,
            $imagen,
            $id
        );

        $stmt->execute();
        $stmt->close();
    }

    public static function eliminar($id) {
    $db = Database::conectar();

    // Comprobar si el producto tiene ventas relacionadas.
    $stmt = $db->prepare(
        "SELECT COUNT(*) AS total
         FROM detalle_venta
         WHERE IdProducto = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result()->fetch_object();
    $stmt->close();

    // Si tiene ventas, no permitir la eliminación.
    if ($resultado->total > 0) {
        $db->close();
        return false;
    }

    // Si no tiene ventas, eliminar el producto.
    $stmt = $db->prepare(
        "DELETE FROM productos WHERE IdProducto = ?"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();

    $db->close();

    return true;
}

    public static function obtenerCategorias() {
    $db = Database::conectar();

    $resultado = $db->query(
        "SELECT * FROM categorias ORDER BY Nombre ASC"
    );

    return $resultado;
}
}