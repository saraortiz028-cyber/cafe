<?php
require_once "config/database.php";

class Cliente {
    public static function obtenerTodos() {
        $db = Database::conectar();
        return $db->query("SELECT * FROM clientes");
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE IdCliente = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($nombres, $apellidos, $telefono, $correo, $direccion) {
        $db = Database::conectar();
        $fechaRegistro = date('Y-m-d');
        $stmt = $db->prepare("INSERT INTO clientes(Nombres, Apellidos, Telefono, Correo, Direccion, FechaRegistro) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nombres, $apellidos, $telefono, $correo, $direccion, $fechaRegistro);
        $stmt->execute();
    }

    public static function actualizar($id, $nombres, $apellidos, $telefono, $correo, $direccion) {
        $db = Database::conectar();
        $stmt = $db->prepare("UPDATE clientes SET Nombres=?, Apellidos=?, Telefono=?, Correo=?, Direccion=? WHERE IdCliente=?");
        $stmt->bind_param("sssssi", $nombres, $apellidos, $telefono, $correo, $direccion, $id);
        $stmt->execute();
    }

    public static function eliminar($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("DELETE FROM clientes WHERE IdCliente = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>