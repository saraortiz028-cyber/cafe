<?php
require_once "models/Categorias.php";

class CategoriaController {

    public function index() {
        $categorias = Categoria::obtenerTodos();
        require "views/categorias/index.php";
    }

    public function crear() {
        if ($_POST) {
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';

            Categoria::guardar($nombre, $descripcion);
            
            header("Location: index.php?controlador=categoria&accion=index");
            exit;
        }
        require "views/categorias/crear.php";
    }

    public function editar() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        if (!$id) {
            header("Location: index.php?controlador=categoria&accion=index");
            exit();
        }

        if ($_POST) {
            // Si en la vista de editar también agregaste la descripción, 
            // recuerda actualizarlo aquí también capturando $_POST['descripcion']
            $nombre = $_POST['nombre'] ?? '';
            $descripcion = $_POST['descripcion'] ?? '';
            
            Categoria::actualizar($id, $nombre, $descripcion);
            header("Location: index.php?controlador=categoria&accion=index");
            exit();
        }

        $categoria = Categoria::obtenerPorId($id);
        require "views/categorias/editar.php";
    }

    public function eliminar() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            Categoria::eliminar($id);
        }
        header("Location: index.php?controlador=categoria&accion=index");
        exit();
    }
}
?>