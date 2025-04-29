<?php
require_once 'Controllers/Controller.php';
require_once 'Models/UsuariosModel.php';


class AdminUsuariosController extends Controller
{
    private $model;
    private $base = "admin/usuarios";

    function __construct()
    {
        $this->model = new UsuariosModel();
        session_start();
    }

    function index()
    {
        $this->verificarSesionAdmin('administrador');
        $search = isset($_POST['search']) ? $_POST['search'] : null;
        $data = [];
        $data['usuarios'] = $this->model->get($search);
        $data['search'] = $search;
        $this->render("Admin/UsuariosView.php", $data);
    }

    function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($_SESSION['usuario_id'])) {
                header("Location: /admin/productos");
                exit;
            }
            $this->render("Admin/LoginView.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validación más estricta de campos vacíos
            $username = isset($_POST["username"]) ? trim($_POST["username"]) : '';
            $password = isset($_POST["password"]) ? trim($_POST["password"]) : '';

            // Verificar campos vacíos (incluyendo strings con solo espacios)
            if (strlen($username) === 0 || strlen($password) === 0) {
                $this->redirectWithMessage(false, "Debe completar todos los campos", 'admin');
            }

            try {
                $user = $this->model->login($username);

                if ($user) {
                    if (hash('sha256', $password) === $user["contrasena"]) {
                        // Login exitoso
                        $_SESSION['usuario_id'] = $user["id"];
                        $_SESSION['usuario_rol'] = $user["rol"];
                        header("Location: /admin/productos");
                        exit;
                    }
                }

                // Credenciales incorrectas (usuario no existe o contraseña no coincide)
                $this->redirectWithMessage(false, "Usuario o contraseña incorrectos", 'admin');
            } catch (PDOException $e) {
                error_log("Error en login: " . $e->getMessage());
                $this->redirectWithMessage(false, "Error en el sistema. Intente nuevamente más tarde", 'admin');
            }
        }
    }

    function logout()
    {
        session_destroy();
        header("Location: /admin");
        exit;
    }

    function agregar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->verificarSesionAdmin('administrador');
            $this->render("Admin/UsuariosFormView.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validarDatos('agregar');
            $datos = [
                ':nombre'   => $_POST["nombre"],
                ':correo'   => $_POST["correo"],
                ':contrasena' => $_POST["contrasena"],
                ':rol'      => $_POST["rol"],
                ':estado'   => $_POST["estado"]
            ];
            if ($this->model->insert($datos)) {
                $this->redirectWithMessage(true, "Usuario agregado correctamente", $this->base);
            } else {
                $this->redirectWithMessage(false, "Error al agregar el usuario", $this->base . "/agregar");
            }
        }
    }

    function editar($params)
    {
        $this->verificarSesionAdmin('administrador');
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if (isset($params[0])) {
                $data = [];
                $data['usuario'] = $this->model->getOne($params[0]);
                $this->render("Admin/UsuariosFormView.php", $data);
            } else {
                header("Location: /$this->base");
            }
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->validarDatos('editar');

            if ($_POST['estado'] == '0' && $_POST['id'] == $_SESSION['usuario_id']) {
                $this->redirectWithMessage(false, "No puede deshabilitar su propia cuenta", $this->base . '/editar/' . $_POST['id']);
            }

            if ($this->model->verificarCountAdmin()['num'] == 1 && $_POST['rol'] == 'empleado' && $_POST['id'] == $_SESSION['usuario_id']) {
                $this->redirectWithMessage(false, "No puede haber menos de un administrador activo", $this->base . '/editar/' . $_POST['id']);
            }

            $datos = [
                ':id'       => $_POST["id"],
                ':nombre'   => $_POST["nombre"],
                ':correo'   => $_POST["correo"],
                ':contrasena' => $_POST["contrasena"],
                ':rol'      => $_POST["rol"],
                ':estado'   => $_POST["estado"]
            ];
            if ($this->model->update($datos)) {
                $this->redirectWithMessage(true, "Usuario actualizado correctamente", $this->base);
            } else {
                $this->redirectWithMessage(false, "Error al actualizar el usuario", $this->base . '/editar/' . $_POST['id']);
            }
        }
    }

    function eliminar($params)
    {
        if (isset($params[0])) {
            if ($this->model->delete($params[0])) {
                $this->redirectWithMessage(true, "Usuario eliminado correctamente", $this->base);
            } else {
                $this->redirectWithMessage(false, "Error al eliminar el usuario", $this->base);
            }
        }
    }

    function validarDatos($action)
    {
        // Validación más estricta de campos vacíos
        $nombre = isset($_POST["nombre"]) ? trim($_POST["nombre"]) : '';
        $correo = isset($_POST["correo"]) ? trim($_POST["correo"]) : '';
        $contrasena = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : '';
        $rol = isset($_POST["rol"]) ? trim($_POST["rol"]) : '';
        $estado = isset($_POST["estado"]) ? trim($_POST["estado"]) : '';

        if ($action == 'agregar') {
            $url = $this->base . '/agregar';
            if (strlen($contrasena) === 0) {
                $this->redirectWithMessage(false, "Debe completar todos los campos", $url);
            }
        } else if ($action == 'editar') {
            $url = $this->base . '/editar/' . $_POST["id"];
        }

        // Verificar campos vacíos (incluyendo strings con solo espacios)           
        if (strlen($nombre) === 0 || strlen($correo) === 0 || strlen($rol) === 0 || strlen($estado) === 0) {
            $this->redirectWithMessage(false, "Debe completar todos los campos", $url);
        }
    }
}
