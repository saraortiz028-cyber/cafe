<?php
require_once "config/database.php";

class Producto {

    public static function obtenerTodos() {
        $db = Database::conectar();
        return $db->query("SELECT p.*, c.Nombre as NombreCategoria FROM productos p LEFT JOIN categorias c ON p.IdCategoria = c.IdCategoria");
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT * FROM productos WHERE IdProducto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($nombre, $descripcion, $precio, $existencias, $idCategoria = null) {
        $db = Database::conectar();
        $stmt = $db->prepare("INSERT INTO productos(Nombre, Descripcion, Precio, Existencias, IdCategoria) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdii", $nombre, $descripcion, $precio, $existencias, $idCategoria);
        $stmt->execute();
    }

    public static function actualizar($id, $nombre, $descripcion, $precio, $existencias, $idCategoria = null) {
        $db = Database::conectar();
        $stmt = $db->prepare("UPDATE productos SET Nombre=?, Descripcion=?, Precio=?, Existencias=?, IdCategoria=? WHERE IdProducto=?");
        $stmt->bind_param("ssdiii", $nombre, $descripcion, $precio, $existencias, $idCategoria, $id);
        $stmt->execute();
    }

    public static function eliminar($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("DELETE FROM productos WHERE IdProducto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // Método adicional de apoyo para poblar el <select> de categorías en las vistas
    public static function obtenerCategorias() {
        $db = Database::conectar();
        return $db->query("SELECT * FROM categorias");
    }
}
?>