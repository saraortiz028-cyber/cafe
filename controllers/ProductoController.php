<?php
require_once "models/Productos.php";

class ProductoController {

    public function index() {
        $productos = Producto::obtenerTodos();
        require "views/productos/index.php";
    }

    public function crear()
    {
        $editando = false;
        $producto = null;
        $error = null;

        $categorias = Producto::obtenerCategorias();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre      = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio      = $_POST['precio'] ?? '';
            $existencias = $_POST['existencias'] ?? '';
            $id_categoria = $_POST['id_categoria'] ?? '';


            if (
                $nombre === '' ||
                $precio === '' ||
                !is_numeric($precio) ||
                $existencias === '' ||
                !ctype_digit((string) $existencias)
            ) {

                $error = "Revisa el nombre, el precio y las existencias.";

                $producto = (object) [
                    'nombre'       => $nombre,
                    'descripcion'  => $descripcion,
                    'precio'       => $precio,
                    'existencias'  => $existencias,
                    'id_categoria' => $id_categoria
                ];

            } else {

                Producto::guardar(
                    $nombre,
                    $descripcion,
                    (float) $precio,
                    (int) $existencias,
                    $id_categoria !== '' ? (int) $id_categoria : null
                );

                header(
                    "Location: index.php?controlador=producto&accion=index"
                );

                exit;
            }
        }


        require "views/productos/formulario.php";
    }


    public function editar()
    {
        $id = $_GET['id'] ?? null;


        if (!$id || !ctype_digit((string) $id)) {

            header(
                "Location: index.php?controlador=producto&accion=index"
            );

            exit;
        }


        $producto = Producto::obtenerPorId($id);


        if (!$producto) {

            header(
                "Location: index.php?controlador=producto&accion=index"
            );

            exit;
        }


        $editando = true;
        $error = null;

        $categorias = Producto::obtenerCategorias();


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre       = trim($_POST['nombre'] ?? '');
            $descripcion  = trim($_POST['descripcion'] ?? '');
            $precio       = $_POST['precio'] ?? '';
            $existencias  = $_POST['existencias'] ?? '';
            $id_categoria = $_POST['id_categoria'] ?? '';


            if (
                $nombre === '' ||
                $precio === '' ||
                !is_numeric($precio) ||
                $existencias === '' ||
                !ctype_digit((string) $existencias)
            ) {

                $error = "Revisa el nombre, el precio y las existencias.";

                $producto->nombre = $nombre;
                $producto->descripcion = $descripcion;
                $producto->precio = $precio;
                $producto->existencias = $existencias;
                $producto->id_categoria = $id_categoria;

            } else {

                Producto::actualizar(
                    $id,
                    $nombre,
                    $descripcion,
                    (float) $precio,
                    (int) $existencias,
                    $id_categoria !== '' ? (int) $id_categoria : null
                );

                header(
                    "Location: index.php?controlador=producto&accion=index"
                );

                exit;
            }
        }


        require "views/productos/formulario.php";
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