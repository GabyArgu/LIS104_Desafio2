<?php
require_once 'Controllers/Controller.php';
require_once 'Models/ProductosModel.php';
require_once 'Models/CategoriasModel.php';


class AdminProductosController extends Controller
{
    private $model;
    private $modelCategorias;
    private $base = 'admin/productos';

    function __construct()
    {
        $this->model = new ProductosModel();
        $this->modelCategorias = new CategoriasModel();
        session_start();
    }

    function index()
    {
        $this->verificarSesionAdmin(null);
        $search = isset($_POST['search']) ? $_POST['search'] : null;
        $data = [];
        $data['productos'] = $this->model->get($search);
        $data['search'] = $search;
        $this->render("Admin/ProductosView.php", $data);
    }

    function agregar()
    {
        $this->verificarSesionAdmin(null);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [];
            $data['categorias'] = $this->modelCategorias->get();
            $this->render("Admin/ProductosFormView.php", $data);
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validarDatos('agregar');

            $datos = [
                ':codigo'       => $_POST['codigo'],
                ':nombre'       => $_POST['nombre'],
                ':descripcion'  => $_POST['descripcion'],
                ':imagen'       => $_FILES['imagen']['name'] ?? '',
                ':categoria_id' => $_POST['categoria_id'],
                ':precio'       => $_POST['precio'] ?? 0.00,
                ':existencias'  => $_POST['existencias'] ?? 0,
            ];

            if ($this->model->insert($datos)) {
                $this->guardarImagen();
                $this->redirectWithMessage(true, 'El producto se ha agregado correctamente', $this->base);
            } else {
                $this->redirectWithMessage(false, 'Error al agregar el producto', $this->base . '/agregar');
            }
        }
    }

    function editar($params)
    {
        $this->verificarSesionAdmin(null);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($params[0])) {
                $data = [];
                $data['categorias'] = $this->modelCategorias->get();
                $data['producto'] = $this->model->getOne($params[0]);
                $this->render("Admin/ProductosFormView.php", $data);
            } else {
                header("Location: /$this->base");
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validarDatos('editar');

            $datos = [
                ':id'           => $_POST['id'],
                ':codigo'       => $_POST['codigo'],
                ':nombre'       => $_POST['nombre'],
                ':descripcion'  => $_POST['descripcion'],
                ':imagen'       => $_FILES['imagen']['name'] ?? '',
                ':categoria_id' => $_POST['categoria_id'],
                ':precio'       => $_POST['precio'] ?? 0.00,
                ':existencias'  => $_POST['existencias'] ?? 0,
            ];

            $imagenAnterior = $this->model->getOne($_POST['id'])['imagen'];

            if ($this->model->update($datos)) {
                if (!empty($_FILES['imagen']['name'])) {
                    $this->eliminarImagen($imagenAnterior);
                }
                $this->guardarImagen();
                $this->redirectWithMessage(true, 'El producto se ha actualizado correctamente', $this->base);
            } else {
                $this->redirectWithMessage(false, 'Error al actualizar el producto', $this->base . '/editar/' . $_POST['id']);
            }
        }
    }

    function eliminar($params)
    {
        $this->verificarSesionAdmin(null);
        $imagen = $this->model->getOne($params[0])['imagen'];
        if ($this->model->delete($params[0])) {
            $this->eliminarImagen($imagen);
            $this->redirectWithMessage(true, 'El producto se ha eliminado correctamente', $this->base);
        } else {
            $this->redirectWithMessage(false, 'Error al eliminar el producto', $this->base);
        }
    }

    function validarDatos($action)
    {
        if ($action == 'agregar') {
            $url = $this->base . '/agregar';

            if ($this->model->getByCode($_POST['codigo'])) {
                $this->redirectWithMessage(false, 'El código ya existe', $url);
            }
        } else if ($action == 'editar') {
            $url = $this->base . '/editar/' . $_POST['id'];
        }

        //Obtener información de la imagen si existe
        if (!empty($_FILES['imagen']['name'])) {
            $nombre_imagen = $_FILES['imagen']['name'];
            $extension = strtolower(pathinfo($nombre_imagen, PATHINFO_EXTENSION));
            $extensiones_permitidas = ['jpg', 'jpeg', 'png'];
        }

        //Manejo de errores
        if (!preg_match('/^PROD\d{5}$/', $_POST['codigo'])) {
            $this->redirectWithMessage(false, 'El codigo debe tener el formato PRODXXXXX', $url);
        } else if (empty($_POST['nombre'])) {
            $this->redirectWithMessage(false, 'El nombre no puede estar vacio', $url);
        } else if (empty($_POST['descripcion'])) {
            $this->redirectWithMessage(false, 'La descripción no puede estar vacia', $url);
        } else if ($_POST['existencias'] < 0) {
            $this->redirectWithMessage(false, 'Las existencias no pueden ser negativas', $url);
        } else if ($_POST['precio'] < 0) {
            $this->redirectWithMessage(false, 'El precio no puede ser negativo', $url);
        } else if (!is_numeric($_POST['existencias'])) {
            $this->redirectWithMessage(false, 'Las existencias deben ser de tipo entero', $url);
        } else if (!empty($_FILES['imagen']['name']) && !in_array($extension, $extensiones_permitidas)) {
            $this->redirectWithMessage(false, 'El archivo debe ser una imagen de tipo jpg, jpeg o png', $url);
        }
    }

    function eliminarImagen($imagen)
    {
        $this->verificarSesionAdmin(null);
        if (file_exists('Static/Img/Productos/' . $imagen)) {
            unlink('Static/Img/Productos/' . $imagen);
        }
    }

    function guardarImagen()
    {
        $this->verificarSesionAdmin(null);
        if (!empty($_FILES['imagen']['name'])) {
            $ruta_destino = 'Static/Img/Productos/' . $_FILES['imagen']['name'];  // Ruta donde se guardará la imagen
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta_destino)) {
                $this->redirectWithMessage(false, 'Error al guardar la imagen', $this->base . '/agregar');
            }
        }
    }
}
