<?php
require_once 'Controllers/Controller.php';
require_once 'Models/ClientesModel.php';


class PublicClientesController extends Controller
{
    private $model;
    private $base = "public/clientes";

    function __construct()
    {
        $this->model = new ClientesModel();
        session_start();
    }

    function index()
    {
        header("Location: /public/productos");
    }

    function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->verificarSesionPublic(false);
            $this->render("Public/LoginView.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validación más estricta de campos vacíos
            $username = isset($_POST["correo"]) ? trim($_POST["correo"]) : '';
            $password = isset($_POST["contrasena"]) ? trim($_POST["contrasena"]) : '';

            // Verificar campos vacíos (incluyendo strings con solo espacios)
            if (strlen($username) === 0 || strlen($password) === 0) {
                $this->redirectWithMessage(false, "Debe completar todos los campos", "$this->base/login");
            }

            try {
                $user = $this->model->getByCorreo($username);

                if ($user) {
                    if (hash('sha256', $password) === $user["contrasena"] && $user["habilitado"] == 1) {
                        // Login exitoso
                        $_SESSION['cliente_id'] = $user["id"];
                        $_SESSION['cliente_nombre'] = $user["nombre"];
                        header("Location: /");
                        exit;
                    }
                }

                // Credenciales incorrectas (usuario no existe o contraseña no coincide)
                $this->redirectWithMessage(false, "Usuario o contraseña incorrectos", "$this->base/login");
            } catch (PDOException $e) {
                error_log("Error en login: " . $e->getMessage());
                $this->redirectWithMessage(false, "Error en el sistema. Intente nuevamente más tarde", "$this->base/login");
            }
        }
    }

    function logout()
    {
        session_destroy();
        header("Location: /");
        exit;
    }

    function registro()
    {
        $this->verificarSesionPublic(false);
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->render("Public/RegistroFormView.php");
        } else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (
                empty($_POST["nombre"]) ||
                empty($_POST["correo"]) ||
                empty($_POST["contrasena"]) ||
                empty($_POST["direccion"]) ||
                empty($_POST["telefono"])
            ) {
                $this->redirectWithMessage(false, "Debe completar todos los campos", "$this->base/registro");
            }

            if (!filter_var($_POST["correo"], FILTER_VALIDATE_EMAIL)) {
                $this->redirectWithMessage(false, "El correo no es valido", "$this->base/registro");
            }

            if ($_POST["contrasena"] != $_POST["contrasena2"]) {
                $this->redirectWithMessage(false, "Las contraseñas no coinciden", "$this->base/registro");
            }

            $datos = [
                ':nombre'       => $_POST["nombre"],
                ':correo'       => $_POST["correo"],
                ':contrasena'   => $_POST["contrasena"],
                ':direccion'    => $_POST["direccion"],
                ':telefono'     => $_POST["telefono"]
            ];

            if (!empty($this->model->getByCorreo($_POST["correo"]))) {
                $this->redirectWithMessage(false, "El correo ya esta registrado", "$this->base/registro");
            }

            // Verificamos si la operación fue exitosa
            if ($this->model->insert($datos)) {
                $this->redirectWithMessage(true, "Se ha registrado correctamente", "$this->base/login");
            } else {
                $this->redirectWithMessage(false, "Ocurrió un error en el registro", "$this->base/registro");
            }
        }
    }
}
