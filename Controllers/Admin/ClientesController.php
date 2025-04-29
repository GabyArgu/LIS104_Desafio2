<?php
require_once 'Controllers/Controller.php';
require_once 'Models/ClientesModel.php';


class AdminClientesController extends Controller
{
    private $model;
    private $base = "admin/clientes";

    function __construct()
    {
        $this->model = new ClientesModel();
        session_start();
    }

    function index()
    {
        $this->verificarSesionAdmin('administrador');
        $search = isset($_POST['search']) ? $_POST['search'] : null;
        $data = [];
        $data['clientes'] = $this->model->getAll($search);
        $data['search'] = $search;
        $this->render("Admin/ClientesView.php", $data);
    }

    function editar($params)
    {
        $this->verificarSesionAdmin('administrador');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($params[0])) {
                $data = [];
                $data['cliente'] = $this->model->getOne($params[0]);
                $this->render("Admin/ClientesFormView.php", $data);
            } else {
                header("Location: /LIS104_Desafio2/$this->base");
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validarDatos('editar');
            $datos = [
                ':id'           => $_POST["id"],
                ':nombre'       => $_POST["nombre"],
                ':correo'       => $_POST["correo"],
                ':contrasena'   => $_POST["contrasena"],
                ':direccion'    => $_POST["direccion"],
                ':telefono'     => $_POST["telefono"],
                ':habilitado'   => $_POST["habilitado"]
            ];
            if ($this->model->update($datos)) {
                $this->redirectWithMessage(true, "Usuario actualizado correctamente", $this->base);
            } else {
                $this->redirectWithMessage(false, "Error al actualizar el cliente", $this->base . '/editar/' . $_POST['id']);
            }
        }
    }

    function inhabilitar($params)
    {
        $this->verificarSesionAdmin('administrador');
        if (isset($params[0])) {
            if ($this->model->delete($params[0])) {
                $this->redirectWithMessage(true, "Usuario inhabilitado correctamente", $this->base);
            } else {
                $this->redirectWithMessage(false, "Error al inhabilitar el cliente", $this->base);
            }
        }
    }

    function validarDatos($action)
    {
        // Validación más estricta de campos vacíos
        $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : '';
        $correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : '';
        $contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : '';
        $direccion = isset($_POST["direccion"]) ? trim($_POST["direccion"]) : '';
        $telefono = isset($_POST["telefono"]) ? trim($_POST["telefono"]) : '';
        $habilitado = isset($_POST["habilitado"]) ? trim($_POST["habilitado"]) : '';

        if ($action == 'agregar') {
            $url = $this->base . '/agregar';
            if (strlen($contrasena) === 0) {
                $this->redirectWithMessage(false, "Debe completar todos los campos", $url);
            }
        } else if ($action == 'editar') {
            $url = $this->base . '/editar/' . $_POST["id"];
        }

        // Verificar campos vacíos (incluyendo strings con solo espacios)           
        if (strlen($nombre) === 0 || strlen($correo) === 0 || strlen($direccion) === 0 || strlen($telefono) === 0 || strlen($habilitado) === 0) {
            $this->redirectWithMessage(false, "Debe completar todos los campos", $url);
        }
    }
}
