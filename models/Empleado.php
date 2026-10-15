<?php
require_once "config/database.php";

class Empleado {

    public static function obtenerTodos() {
        $db = Database::conectar();
        return $db->query("SELECT * FROM empleados");
    }

    public static function obtenerPorId($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("SELECT * FROM empleados WHERE IdEmpleado = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_object();
    }

    public static function guardar($nombre, $apellido, $direccion, $telefono, $correo, $salario, $idCargo = null, $idSucursal = null) {
        $db = Database::conectar();
        $fechaContratacion = date('Y-m-d');
        
        $stmt = $db->prepare("INSERT INTO empleados(Nombre, Apellido, Direccion, Telefono, Correo, Salario, FechaContratacion, IdCargo, IdSucursal) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssdsii", $nombre, $apellido, $direccion, $telefono, $correo, $salario, $fechaContratacion, $idCargo, $idSucursal);
        $stmt->execute();
    }

    public static function actualizar($id, $nombre, $apellido, $direccion, $telefono, $correo, $salario, $idCargo = null, $idSucursal = null) {
        $db = Database::conectar();
        $stmt = $db->prepare("UPDATE empleados SET Nombre=?, Apellido=?, Direccion=?, Telefono=?, Correo=?, Salario=?, IdCargo=?, IdSucursal=? WHERE IdEmpleado=?");
        $stmt->bind_param("sssssdiii", $nombre, $apellido, $direccion, $telefono, $correo, $salario, $idCargo, $idSucursal, $id);
        $stmt->execute();
    }

    public static function eliminar($id) {
        $db = Database::conectar();
        $stmt = $db->prepare("DELETE FROM empleados WHERE IdEmpleado = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>