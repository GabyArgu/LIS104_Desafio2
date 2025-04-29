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

if (empty($slices[2]) || strtolower($slices[2]) == "public") {
    $default = "Productos";
    $defaultMethod = "Index";
} else if (strtolower($slices[2]) == "admin") {
    $default = "Usuarios";
    if (empty($slices[3])) {
        $defaultMethod = "Login";
    } else {
        $defaultMethod = "Index";
    }
}

$controller = (empty($slices[2]) ? "public" : $slices[2]) . (empty($slices[3]) ? $default : $slices[3]) . "Controller";
$method = empty($slices[4]) ? $defaultMethod : $slices[4];
$params = empty($slices[5]) ? [] : array_slice($slices, 5);

$cont = new $controller;
$cont->$method($params);
