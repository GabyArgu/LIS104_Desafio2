<?php
require_once 'Controllers/Controller.php';
require_once 'Models/ProductosModel.php';


class PublicProductosController extends Controller
{
    private $model;

    function __construct()
    {
        $this->model = new ProductosModel();
        session_start();
    }

    function index() {
        $search = isset($_POST['search']) ? $_POST['search'] : null;
        $data = [];
        $data['productos'] = $this->model->get($search);
        $this->render("Public/ProductosView.php", $data);
    }

    function detalle($params) {
        $data = [];
        $data['producto'] = $this->model->getOne($params[0]);
        $this->render("Public/ProductoDetalleView.php", $data);
    }
}
