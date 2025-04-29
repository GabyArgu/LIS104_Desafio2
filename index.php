<?php
include_once 'Controllers/Admin/ProductosController.php';
include_once 'Controllers/Admin/UsuariosController.php';
include_once 'Controllers/Admin/CategoriasController.php';
include_once 'Controllers/Admin/VentasController.php';
include_once 'Controllers/Admin/ClientesController.php';

include_once 'Controllers/Public/ProductosController.php';
include_once 'Controllers/Public/ClientesController.php';
include_once 'Controllers/Public/VentasController.php';

$url = $_SERVER['REQUEST_URI'];
$slices = explode('/', $url);

if (empty($slices[1]) || strtolower($slices[1]) == "public") {
    $default = "Productos";
    $defaultMethod = "Index";
} else if (strtolower($slices[1]) == "admin") {
    $default = "Usuarios";
    if (empty($slices[2])) {
        $defaultMethod = "Login";
    } else {
        $defaultMethod = "Index";
    }
}

$controller = (empty($slices[1]) ? "public" : $slices[1]) . (empty($slices[2]) ? $default : $slices[2]) . "Controller";
$method = empty($slices[3]) ? $defaultMethod : $slices[3];
$params = empty($slices[4]) ? [] : array_slice($slices, 4);

$cont = new $controller;
$cont->$method($params);
