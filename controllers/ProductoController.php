<?php
require_once "models/Productos.php";

class ProductoController {

    public function index() {
        $productos = Producto::obtenerTodos();
        require "views/productos/index.php";
    }

    public function crear() {
        if ($_POST) {
            Producto::guardar(
                $_POST['nombre'], 
                $_POST['descripcion'],
                $_POST['precio'], 
                $_POST['existencias'],
                $_POST['id_categoria'] ?? null
            );
            header("Location: index.php?controlador=producto&accion=index");
            exit;
        }
        $categorias = Producto::obtenerCategorias(); // Necesario para el select del formulario
        require "views/productos/crear.php";
    }

    public function editar() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            header("Location: index.php?controlador=producto&accion=index");
            exit();
        }

        if ($_POST) {
            Producto::actualizar(
                $id, 
                $_POST['nombre'], 
                $_POST['descripcion'],
                $_POST['precio'], 
                $_POST['existencias'],
                $_POST['id_categoria'] ?? null
            );
            header("Location: index.php?controlador=producto&accion=index");
            exit();
        }

        $producto = Producto::obtenerPorId($id);
        $categorias = Producto::obtenerCategorias(); // Necesario para el select en la edición
        require "views/productos/editar.php";
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            Producto::eliminar($id);
        }
        header("Location: index.php?controlador=producto&accion=index");
        exit();
    }
}
?>