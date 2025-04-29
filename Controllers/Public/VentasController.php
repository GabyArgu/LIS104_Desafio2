<?php

use FontLib\Table\Type\head;

require_once 'Controllers/Controller.php';
require_once 'Models/VentasModel.php';


class PublicVentasController extends Controller
{
    private $model;
    private $base = 'public/ventas';

    function __construct()
    {
        $this->model = new VentasModel();
        session_start();
    }

    function index()
    {
        header("Location: /LIS104_Desafio2/$this->base/carrito");
    }

    function carrito()
    {
        $this->verificarSesionPublic(true);
        $data = [];
        $data['carrito'] = $this->model->getCarrito();
        $this->render("Public/CarritoView.php", $data);
    }

    function agregarProducto()
    {
        $this->verificarSesionPublic(true);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Si no hay carrito, lo creamos
            $ventaId = $this->model->existeCarrito()["id"];
            if (empty($ventaId)) {
                $ventaId = $this->model->insertVenta();
            }

            if (!empty($this->model->existeProductoCarrito($_POST["producto_id"]))) {
                $this->redirectWithMessage(false, "El producto ya se encuentra en el carrito", "public/productos/detalle/" . $_POST["producto_id"]);
            } else {
                $datos = [
                    ":venta_id" => $ventaId,
                    ":producto_id" => $_POST["producto_id"],
                    ":cantidad" => $_POST["cantidad"],
                    ":precio_unitario" => $_POST["precio_unitario"],
                ];
                if ($this->model->insertDetalle($datos)) {
                    $this->redirectWithMessage(true, "Producto agregado con éxito al carrito", "public/productos/detalle/" . $_POST["producto_id"]);
                } else {
                    $this->redirectWithMessage(false, "Error al agregar el producto al carrito", "public/productos/detalle/" . $_POST["producto_id"]);
                }
            }
        }
    }

    function actualizarCantidad()
    {
        $this->verificarSesionPublic(true);
        // Si la cantidad es 0, se elimina el producto
        if ($_POST["cantidad"] == 0) {
            if ($this->model->removeProducto($_POST["detalle_id"])) {
                $this->redirectWithMessage(true, "Producto eliminado con éxito del carrito", "$this->base/carrito");
            } else {
                $this->redirectWithMessage(false, "Error al eliminar el producto del carrito", "$this->base/carrito");
            }
        } else if ($_POST["cantidad"] < 0) {
            $this->redirectWithMessage(false, "La cantidad debe ser mayor a 0, ó 0 para eliminar", "$this->base");
        } else {
            $existencias = $this->model->getExistencias($_POST["producto_id"]);
            if ($existencias['existencias'] >= $_POST["cantidad"]) {
                if ($this->model->updateCantidad($_POST["detalle_id"], $_POST["cantidad"])) {
                    $this->redirectWithMessage(true, "Cantidad actualizada con éxito", "$this->base");
                } else {
                    $this->redirectWithMessage(false, "Error al actualizar la cantidad", "$this->base");
                }
            } else {
                $this->redirectWithMessage(false, "La cantidad es mayor al stock disponible", "$this->base");
            }
        }
    }

    function pagarCarrito()
    {
        // Intentamos generar el PDF del comprobante
        try {
            $result = $this->model->generarPDFComprobante($this->model->getCarrito(), $_POST["total"], $_SESSION['cliente_nombre']);
        } catch (Exception $e) {
            $this->redirectWithMessage(false, "Error al generar el comprobante", $this->base);
        }

        if ($result) {
            if ($this->model->pagarCarrito($_POST["total"])) {
                $_SESSION['result'] = [
                    "status" => true,
                    "mensaje" => "Compra realizada con éxito"
                ];
            } else {
                $_SESSION['result'] = [
                    "status" => false,
                    "mensaje" => "Error al realizar la compra"
                ];
            }
        }
        exit;
    }

    function historial()
    {
        $this->verificarSesionPublic(true);
        $data = [];
        $data['historial'] = $this->model->getHistorialCompras();
        $this->render("Public/HistorialView.php", $data);
    }

    function detalle($params)
    {
        $this->verificarSesionPublic(true);
        if($this->model->getVenta($params[0])['cliente_id'] != $_SESSION['cliente_id']){ 
            header("Location: /LIS104_Desafio2/$this->base/historial");
        }else{
            $data = [];
            $data['detalle'] = $this->model->getDetallesCompra($params[0]);
            $this->render("Public/CompraDetalleView.php", $data);
        }
    }

    function comprobante($params)
    {
        $this->verificarSesionPublic(true);
        $venta = $this->model->getVenta($params[0]);
        if($venta['cliente_id'] != $_SESSION['cliente_id']){ 
            header("Location: /LIS104_Desafio2/$this->base/historial");
        }else{
            $productos = $this->model->getDetallesCompra($params[0]);
            if(!$this->model->generarPDFComprobante($productos, $venta['total'], $_SESSION['cliente_nombre'])){
                header("Location: /LIS104_Desafio2/$this->base/historial");
            }
        }
    }
}
