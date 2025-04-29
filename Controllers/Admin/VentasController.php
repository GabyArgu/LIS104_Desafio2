<?php
require_once 'Controllers/Controller.php';
require_once 'Models/VentasModel.php';
require_once 'Models/ClientesModel.php';


class AdminVentasController extends Controller
{
    private $model;
    private $base = "admin/usuarios";

    function __construct()
    {
        $this->model = new VentasModel();
        session_start();
    }

    function index()
    {
        $this->verificarSesionAdmin(null);
        $search = isset($_POST['search']) ? $_POST['search'] : null;
        $data = [];
        $data['ventas'] = $this->model->getVentas($search);
        $data['search'] = $search;
        $this->render("Admin/VentasView.php", $data);
    }

    function detalle($params)
    {
        $this->verificarSesionAdmin(null);
        $data = [];
        $data['detalle'] = $this->model->getDetallesVenta($params[0]);
        $this->render("Admin/VentaDetalleView.php", $data);
    }

    function comprobante($params)
    {
        $this->verificarSesionAdmin(null);
        $venta = $this->model->getVenta($params[0]);
        $productos = $this->model->getDetallesVenta($params[0]);
        $ClienteModel = new ClientesModel();
        $cliente = $ClienteModel->getOne($venta['cliente_id']);
        if (!$this->model->generarPDFComprobante($productos, $venta['total'], $cliente['nombre'])) {
            header("Location: $this->base/historial");
        }
    }
}
