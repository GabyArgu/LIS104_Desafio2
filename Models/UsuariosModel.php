<?php
require_once 'Model.php';

class UsuariosModel extends Model
{
    // Obtener un usuario por correo
    public function login($correo)
    {
        $query = "SELECT * FROM usuarios WHERE correo = :correo AND estado = 1";
        $params = ['correo' => $correo];
        return $this->get_row($query, $params);
    }

    // Obtener usuarios
    public function get()
    {
        $query = "SELECT * FROM usuarios";
        return $this->get_rows($query);
    }

    // Agregar un usuario
    public function insert($datos)
    {
        $query = "INSERT INTO usuarios (nombre, correo, contrasena, rol, estado) 
                  VALUES (:nombre, :correo, SHA2(:contrasena, 256), :rol, :estado)";
        return $this->execute($query, $datos);
    }

    // Obtener un usuario por ID
    public function getOne($id)
    {
        $query = "SELECT * FROM usuarios WHERE id = :id";
        $params = ['id' => $id];
        return $this->get_row($query, $params);
    }

    // Editar un usuario
    public function update($datos)
    {
        $query = "UPDATE usuarios SET nombre = :nombre, correo = :correo, 
                    contrasena = CASE 
                                    WHEN :contrasena IS NULL OR :contrasena = '' 
                                        THEN contrasena 
                                        ELSE SHA2(:contrasena, 256) 
                                    END, 
                  rol = :rol, estado = :estado WHERE id = :id";
        return $this->execute($query, $datos);
    }

    // Verificar cantidad de administradores
    public function verificarCountAdmin()
    {
        $query = "SELECT COUNT(*) as num FROM usuarios WHERE rol = 'administrador' AND estado = 1";
        return $this->get_row($query);
    }

    // Eliminar un usuario
    public function delete($id)
    {
        $query = "DELETE FROM usuarios WHERE id = :id";
        return $this->execute($query, ['id' => $id]);
    }
}
