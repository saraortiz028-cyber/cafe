<?php
require_once "models/Categorias.php";

class CategoriaController {

    public function index() {
        $categorias = Categoria::obtenerTodos();
        require "views/categorias/index.php";
    }

    public function crear() {
    $editando = false;
    $categoria = null;
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if ($nombre === '') {
            $error = 'El nombre de la categoría es obligatorio.';
        } else {
            Categoria::guardar($nombre, $descripcion);

            header("Location: index.php?controlador=categoria&accion=index");
            exit;
        }

        $categoria = (object) [
            'nombre' => $nombre,
            'descripcion' => $descripcion
        ];
    }

    require "views/categorias/formulario.php";
}

public function editar() {
    $id = $_GET['id'] ?? null;

    if (!$id) {
        header("Location: index.php?controlador=categoria&accion=index");
        exit;
    }

    $categoria = Categoria::obtenerPorId($id);

    if (!$categoria) {
        header("Location: index.php?controlador=categoria&accion=index");
        exit;
    }

    $editando = true;
    $error = null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');

        if ($nombre === '') {
            $error = 'El nombre de la categoría es obligatorio.';
        } else {
            Categoria::actualizar($id, $nombre, $descripcion);

            header("Location: index.php?controlador=categoria&accion=index");
            exit;
        }

        $categoria->Nombre = $nombre;
        $categoria->Descripcion = $descripcion;
    }

    require "views/categorias/formulario.php";
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