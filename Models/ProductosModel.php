<?php
require_once 'Model.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Ajusta la ruta si es necesario

use Dompdf\Dompdf;

class ProductosModel extends Model
{
    // Obtener los productos
    public function get($search = null)
    {
        $query = "SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE (p.nombre LIKE :search OR :search IS NULL)";
        $parametros = [':search' => "%$search%"];
        return $this->get_rows($query, $parametros);
    }

    // Insertar un producto
    public function insert($datos)
    {
        $query = "INSERT INTO productos (codigo, nombre, descripcion, imagen, categoria_id, precio, existencias) 
                VALUES (:codigo, :nombre, :descripcion, :imagen, :categoria_id, :precio, :existencias)";
        return $this->execute($query, $datos);
    }

    // Obtener un producto por su ID
    public function getOne($id)
    {
        $query = "SELECT p.*, c.nombre AS categoria FROM productos p LEFT JOIN categorias c ON p.categoria_id = c.id WHERE p.id = :id";
        return $this->get_row($query, [':id' => $id]);
    }

    // Obtener los productos por codigo
    public function getByCode($code)
    {
        $query = "SELECT * FROM productos WHERE codigo = :code";
        return $this->get_row($query, [':code' => $code]);
    }

    // Actualizar un producto
    public function update($datos)
    {
        $query = "UPDATE productos SET codigo = :codigo, nombre = :nombre, descripcion = :descripcion, 
                    imagen = CASE 
                        WHEN :imagen IS NULL OR :imagen = '' 
                            THEN imagen 
                            ELSE :imagen 
                        END, 
                categoria_id = :categoria_id, precio = :precio, existencias = :existencias WHERE id = :id";
        return $this->execute($query, $datos);
    }

    // Eliminar un producto
    public function delete($id)
    {
        $query = "DELETE FROM productos WHERE id = :id";
        return $this->execute($query, [':id' => $id]);
    }
}
