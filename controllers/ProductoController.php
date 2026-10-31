<?php
require_once "models/Productos.php";

class ProductoController {

    // Procesar y guardar una imagen subida.
    private function procesarImagen($archivo) {

        // Si no se seleccionó ninguna imagen.
        if (
            !isset($archivo['error']) ||
            $archivo['error'] === UPLOAD_ERR_NO_FILE
        ) {
            return [
                'nombre' => null,
                'error' => null
            ];
        }

        // Comprobar errores de subida.
        if ($archivo['error'] !== UPLOAD_ERR_OK) {
            return [
                'nombre' => null,
                'error' => 'Ocurrió un problema al subir la imagen.'
            ];
        }

        // Comprobar tamaño máximo: 3 MB.
        if ($archivo['size'] > 3 * 1024 * 1024) {
            return [
                'nombre' => null,
                'error' => 'La imagen no debe superar los 3 MB.'
            ];
        }

        // Comprobar que realmente sea una imagen.
        $informacion = getimagesize($archivo['tmp_name']);

        if ($informacion === false) {
            return [
                'nombre' => null,
                'error' => 'El archivo seleccionado no es una imagen válida.'
            ];
        }

        // Tipos de imagen permitidos.
        $tiposPermitidos = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/webp' => 'webp'
        ];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tipo = finfo_file($finfo, $archivo['tmp_name']);
        finfo_close($finfo);

        if (!isset($tiposPermitidos[$tipo])) {
            return [
                'nombre' => null,
                'error' => 'Solo se permiten imágenes JPG, PNG o WEBP.'
            ];
        }

        // Crear la carpeta si todavía no existe.
        $directorio = __DIR__ . '/../public/img/productos/';

        if (
            !is_dir($directorio) &&
            !mkdir($directorio, 0755, true)
        ) {
            return [
                'nombre' => null,
                'error' => 'No se pudo acceder a la carpeta de imágenes.'
            ];
        }

        // Generar un nombre único.
        $nombreImagen = 'producto_' .
            bin2hex(random_bytes(8)) .
            '.' . $tiposPermitidos[$tipo];

        // Mover la imagen a la carpeta correspondiente.
        if (
            !move_uploaded_file(
                $archivo['tmp_name'],
                $directorio . $nombreImagen
            )
        ) {
            return [
                'nombre' => null,
                'error' => 'No se pudo guardar la imagen.'
            ];
        }

        return [
            'nombre' => $nombreImagen,
            'error' => null
        ];
    }


    public function index() {
        $productos = Producto::obtenerTodos();
        require "views/productos/index.php";
    }


    public function crear() {

        $editando = false;
        $producto = null;
        $error = null;

        $categorias = Producto::obtenerCategorias();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = $_POST['precio'] ?? '';
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
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'existencias' => $existencias,
                    'id_categoria' => $id_categoria,
                    'Imagen' => null
                ];

            } else {

                // Procesar imagen seleccionada.
                $resultadoImagen = $this->procesarImagen(
                    $_FILES['imagen'] ?? []
                );

                if ($resultadoImagen['error'] !== null) {

                    $error = $resultadoImagen['error'];

                    $producto = (object) [
                        'nombre' => $nombre,
                        'descripcion' => $descripcion,
                        'precio' => $precio,
                        'existencias' => $existencias,
                        'id_categoria' => $id_categoria,
                        'Imagen' => null
                    ];

                } else {

                    Producto::guardar(
                        $nombre,
                        $descripcion,
                        (float) $precio,
                        (int) $existencias,
                        $id_categoria !== '' ? (int) $id_categoria : null,
                        $resultadoImagen['nombre']
                    );

                    header(
                        "Location: index.php?controlador=producto&accion=index"
                    );

                    exit;
                }
            }
        }

        require "views/productos/formulario.php";
    }


    public function editar() {

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

            $nombre = trim($_POST['nombre'] ?? '');
            $descripcion = trim($_POST['descripcion'] ?? '');
            $precio = $_POST['precio'] ?? '';
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

                $producto->nombre = $nombre;
                $producto->descripcion = $descripcion;
                $producto->precio = $precio;
                $producto->existencias = $existencias;
                $producto->id_categoria = $id_categoria;

            } else {

                // Procesar nueva imagen, si se seleccionó.
                $resultadoImagen = $this->procesarImagen(
                    $_FILES['imagen'] ?? []
                );

                if ($resultadoImagen['error'] !== null) {

                    $error = $resultadoImagen['error'];

                    $producto->nombre = $nombre;
                    $producto->descripcion = $descripcion;
                    $producto->precio = $precio;
                    $producto->existencias = $existencias;
                    $producto->id_categoria = $id_categoria;

                } else {

                    // Si no se subió otra imagen, conservar la actual.
                    $imagen = $resultadoImagen['nombre'] !== null
                        ? $resultadoImagen['nombre']
                        : $producto->Imagen;

                    Producto::actualizar(
                        $id,
                        $nombre,
                        $descripcion,
                        (float) $precio,
                        (int) $existencias,
                        $id_categoria !== '' ? (int) $id_categoria : null,
                        $imagen
                    );

                    header(
                        "Location: index.php?controlador=producto&accion=index"
                    );

                    exit;
                }
            }
        }

        require "views/productos/formulario.php";
    }


    public function eliminar() {

        $id = $_GET['id'] ?? null;
        $mensaje = '';

        if ($id && ctype_digit((string) $id)) {

            try {

                $eliminado = Producto::eliminar((int) $id);

                if ($eliminado) {
                    $mensaje = 'eliminado';
                } else {
                    $mensaje = 'tiene_ventas';
                }

            } catch (mysqli_sql_exception $e) {

                error_log(
                    "Error al eliminar producto: " . $e->getMessage()
                );

                $mensaje = 'error';
            }
        }

        header(
            "Location: index.php?controlador=producto&accion=index&mensaje="
            . urlencode($mensaje)
        );

        exit();
    }
}