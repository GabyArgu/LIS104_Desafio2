<?php
require_once 'Model.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta si es necesario

use Dompdf\Dompdf;

class VentasModel extends Model
{
    // Verificar si existe un carrito
    public function existeCarrito()
    {
        $query = "SELECT * FROM ventas WHERE cliente_id = :cliente_id AND estado = 0";
        $parametros = [':cliente_id' => $_SESSION['cliente_id']];
        return $this->get_row($query, $parametros);
    }
    // Verificar si el producto ya está en el carrito
    public function existeProductoCarrito($producto_id)
    {
        $query = "SELECT * FROM detalle_venta 
                  INNER JOIN ventas ON detalle_venta.venta_id = ventas.id 
                  WHERE producto_id = :producto_id AND cliente_id = :cliente_id AND estado = 0";
        $parametros = [':producto_id' => $producto_id, ':cliente_id' => $_SESSION['cliente_id']];
        return $this->get_row($query, $parametros);
    }

    // Insertar una nueva venta (carrito)
    public function insertVenta()
    {
        $query = "INSERT INTO ventas (cliente_id, fecha, total, estado)
                VALUES (:cliente_id, :fecha, :total, :estado)";
        $params = [
            ':cliente_id' => $_SESSION['cliente_id'],
            ':fecha' => date('Y-m-d'),
            ':total' => 0,
            ':estado' => 0
        ];
        return $this->execute($query, $params, true);
    }

    // Insertar un detalle de venta
    public function insertDetalle($datos)
    {
        $query = "INSERT INTO detalle_venta (venta_id, producto_id, cantidad, precio_unitario)
                VALUES (:venta_id, :producto_id, :cantidad, :precio_unitario)";
        return $this->execute($query, $datos, true);
    }

    // Obtener los productos del carrito
    public function getCarrito()
    {
        $query = "SELECT p.*, p.id AS producto_id, cantidad, detalle_venta.id AS detalle_id FROM detalle_venta 
                  INNER JOIN productos p ON detalle_venta.producto_id = p.id
                  INNER JOIN ventas ON detalle_venta.venta_id = ventas.id
                  WHERE cliente_id = :cliente_id AND estado = 0";
        $parametros = [':cliente_id' => $_SESSION['cliente_id']];
        return $this->get_rows($query, $parametros);
    }

    // Actualizar cantidad de un producto en el carrito
    public function updateCantidad($id, $cantidad)
    {
        $query = "UPDATE detalle_venta SET cantidad = :cantidad WHERE id = :id";
        return $this->execute($query, [':cantidad' => $cantidad, ':id' => $id]);
    }

    // Eliminar un producto del carrito
    public function removeProducto($id)
    {
        $query = "DELETE FROM detalle_venta WHERE id = :id";
        $this->execute($query, [':id' => $id]);
    }

    // Obtener las existencias de un producto
    public function getExistencias($id)
    {
        $query = "SELECT existencias FROM productos WHERE id = :id";
        return $this->get_row($query, [':id' => $id]);
    }

    // Pagar el carrito
    public function pagarCarrito($total)
    {
        $fecha = date('Y-m-d');
        $query = "UPDATE ventas SET estado = 1, total = :total, fecha = :fecha WHERE cliente_id = :cliente_id AND estado = 0";
        return $this->execute($query, [':total' => $total, ':fecha' => $fecha, ':cliente_id' => $_SESSION['cliente_id']]);
    }

    // Obtener PDF Comprobante
    public function generarPDFComprobante($productos, $total, $cliente)
    {
        // Generar HTML para el PDF
        $html = "<h1>Gracias por tu compra, {$cliente}</h1>";
        $html .= "<p>Aquí está el detalle de tu compra:</p><ul>";
        foreach ($productos as $producto) {
            $html .= "<li>{$producto['nombre']} - {$producto['cantidad']} unidad(es) - Subtotal: $" . ($producto['cantidad'] * $producto['precio']) . "</li>";
        }
        $html .= "</ul>";
        $html .= "<p>Total: $" . $total . "</p>";

        // Crear el objeto Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper("letter", "portrait");
        $dompdf->render();

        // Obtener el PDF en memoria
        $pdfOutput = $dompdf->output(); // El PDF en una variable en memoria

        // Configurar encabezados para forzar la descarga del archivo PDF
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="comprobante.pdf"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');

        // Imprimir el archivo PDF
        echo $pdfOutput;
        return true;
    }

    // Obtener el historial de compras de un cliente
    public function getHistorialCompras()
    {
        $query = "SELECT * FROM ventas 
                  WHERE cliente_id = :cliente_id AND estado = 1 
                  ORDER BY fecha DESC";
        return $this->get_rows($query, [':cliente_id' => $_SESSION['cliente_id']]);
    }

    // Obtener el detalle de una compra
    public function getDetallesCompra($id)
    {
        $query = "SELECT * FROM detalle_venta 
                  INNER JOIN ventas ON detalle_venta.venta_id = ventas.id 
                  INNER JOIN productos ON detalle_venta.producto_id = productos.id
                  WHERE ventas.id = :id
                  AND ventas.cliente_id = :cliente_id";
        return $this->get_rows($query, [':id' => $id, ':cliente_id' => $_SESSION['cliente_id']]);
    }


    /* ADMIN */

    // Obtener todas las ventas
    public function getVentas($search = null)
    {
        $query = "SELECT *, ventas.id AS venta_id FROM ventas 
                  INNER JOIN clientes ON ventas.cliente_id = clientes.id 
                  WHERE (nombre LIKE :search OR :search IS NULL) OR (fecha LIKE :search OR :search IS NULL)
                  ORDER BY fecha DESC";
        return $this->get_rows($query, [':search' => "%$search%"]);
    }

    // Obtener una venta
    public function getVenta($id)
    {
        $query = "SELECT * FROM ventas WHERE id = :id";
        return $this->get_row($query, [':id' => $id]);
    }

    // Obtener el detalle de una venta
    public function getDetallesVenta($id)
    {
        $query = "SELECT * FROM detalle_venta 
                  INNER JOIN ventas ON detalle_venta.venta_id = ventas.id 
                  INNER JOIN productos ON detalle_venta.producto_id = productos.id
                  WHERE ventas.id = :id";
        return $this->get_rows($query, [':id' => $id]);
    }
}
