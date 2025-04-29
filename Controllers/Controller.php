<?php
abstract class Controller
{
    public function render($view, $viewBag = [])
    {
        $file = "Views/" . $view;
        $file = str_replace("Controller", "", $file);
        if (is_file($file)) {
            extract($viewBag);
            ob_start(); //Abre el buffer
            require($file);
            $content = ob_get_contents();
            ob_end_clean(); //Cerrando el buffer
            echo $content;
        } else {
            echo "<h1>View not found</h1>";
        }
    }

    public function verificarSesionAdmin($rol)
    {
        if (!isset($_SESSION['usuario_id']) || (isset($rol) && $_SESSION['usuario_rol'] != $rol)) {
            header("Location: /LIS104_Desafio2/admin/");
            exit;
        };
    }

    public function verificarSesionPublic($mustBeLoged = true)
    {
        if (($mustBeLoged && !isset($_SESSION['cliente_id'])) || (!$mustBeLoged && isset($_SESSION['cliente_id']))) {
            header("Location: /LIS104_Desafio2/");
            exit;
        };
    }

    function redirectWithMessage($result, $message, $location = '')
    {
        $_SESSION['result'] = [
            "status" => $result,
            "mensaje" => $message
        ];
        header("Location: /LIS104_Desafio2/$location");
        exit;
    }
}
