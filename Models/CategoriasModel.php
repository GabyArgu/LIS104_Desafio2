<?php
require_once 'Model.php';

class CategoriasModel extends Model
{
    // Obtener las categorias
    public function get($search = null)
    {
        $query = "SELECT * FROM categorias WHERE (nombre LIKE :search OR :search IS NULL) ";
        $parametros = [':search' => "%$search%"];
        return $this->get_rows($query, $parametros);
    }

    // Insertar una categoria
    public function insert($datos)
    {
        $query = "INSERT INTO categorias (nombre) VALUES (:nombre)";
        return $this->execute($query, $datos);
    }

    // Obtener una categoria por su id
    public function getOne($id)
    {
        $query = "SELECT * FROM categorias WHERE id = :id";
        return $this->get_row($query, [':id' => $id]);
    }

    // Actualizar una categoria
    public function update($datos)
    {
        $query = "UPDATE categorias SET nombre = :nombre WHERE id = :id";
        return $this->execute($query, $datos);
    }

    // Eliminar una categoria
    public function delete($id)
    {
        $query = "DELETE FROM categorias WHERE id = :id";
        return $this->execute($query, [':id' => $id]);
    }
}
