<?php
require_once 'Controllers/Controller.php';
require_once 'Models/CategoriasModel.php';


class AdminCategoriasController extends Controller
{
    private $model;
    private $base = 'admin/categorias';

    function __construct()
    {
        $this->model = new CategoriasModel();
        session_start();
    }

    function index()
    {
        $this->verificarSesionAdmin('administrador');
        $search = isset($_POST['search']) ? $_POST['search'] : null;
        $data = [];
        $data['categorias'] = $this->model->get($search);
        $data['search'] = $search;
        $this->render("Admin/CategoriasView.php", $data);
    }

    function agregar()
    {
        $this->verificarSesionAdmin('administrador');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->render('Admin/CategoriasFormView.php');
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                ':nombre'   => $_POST["nombre"] ?? null,
            ];

            $resultado = $this->model->insert($datos);

            if ($resultado) {
                $this->redirectWithMessage(true, 'La categoria se ha agregado correctamente', $this->base);
            } else {
                $this->redirectWithMessage(false, 'Error al agregar la categoria', $this->base . '/agregar');
            }
        }
    }

    function editar($params)
    {
        $this->verificarSesionAdmin('administrador');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($params[0])) {
                $data = [];
                $data['categoria'] = $this->model->getOne($params[0]);
                $this->render('Admin/CategoriasFormView.php', $data);
            } else {
                header("Location: /LIS104_Desafio2/$this->base");
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datos = [
                ':id'       => $_POST["id"] ?? null,
                ':nombre'   => $_POST["nombre"] ?? null,
            ];

            $resultado = $this->model->update($datos);

            if ($resultado) {
                $this->redirectWithMessage(true, 'La categoria se ha actualizado correctamente', $this->base);
            } else {
                $this->redirectWithMessage(false, 'Error al actualizar la categoria', $this->base . '/editar/' . $_POST['id']);
            }
        }
    }

    function eliminar($params)
    {
        $id = $params[0];
        $this->verificarSesionAdmin('administrador');
        $resultado = $this->model->delete($id);
        if ($resultado) {
            $this->redirectWithMessage(true, 'La categoria se ha eliminado correctamente', $this->base);
        } else {
            $this->redirectWithMessage(false, 'Error al eliminar la categoria', $this->base);
        }
    }
}
