<?php
require_once 'Model.php';

class ClientesModel extends Model
{
    // Registro de clientes
    public function insert($datos)
    {
        $query = "INSERT INTO clientes (nombre, correo, contrasena, direccion, telefono, habilitado)
                VALUES (:nombre, :correo, SHA2(:contrasena, 256), :direccion, :telefono, 1)";
        return $this->execute($query, $datos);
    }

    // Obtener un cliente por su correo
    public function getByCorreo($correo)
    {
        $query = "SELECT * FROM clientes WHERE correo = :correo";
        $params = ['correo' => $correo];
        return $this->get_row($query, $params);
    }

    // Obtener todos los clientes
    public function getAll($search = null)
    {
        $query = "SELECT * FROM clientes WHERE (nombre LIKE :search OR :search IS NULL)";
        $params = [':search' => "%$search%"];
        return $this->get_rows($query, $params);
    }

    // Obtener un cliente por su ID
    public function getOne($id)
    {
        $query = "SELECT * FROM clientes WHERE id = :id";
        $params = ['id' => $id];
        return $this->get_row($query, $params);
    }

    // Actualizar un cliente
    public function update($datos)
    {
        $query = "UPDATE clientes SET nombre = :nombre, correo = :correo, 
                    contrasena = CASE 
                                    WHEN :contrasena IS NULL OR :contrasena = '' 
                                        THEN contrasena 
                                        ELSE SHA2(:contrasena, 256) 
                                    END, 
                  direccion = :direccion, telefono = :telefono, habilitado = :habilitado WHERE id = :id";
        return $this->execute($query, $datos);
    }

    // Eliminar un cliente
    public function delete($id)
    {
        $query = "UPDATE clientes SET habilitado = 0 WHERE id = :id";
        return $this->execute($query, ['id' => $id]);
    }
}
