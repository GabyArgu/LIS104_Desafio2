<?php
abstract class Model
{
    private $host = "localhost";
    private $user = "root";
    private $password = '';
    private $bd_name = 'textil_export';
    protected $conn;

    protected function open_db()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->bd_name;charset=utf8", $this->user, $this->password);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    protected function close_db()
    {
        $this->conn = null;
    }

    protected function get_rows($query, $params = array())
    {
        try {
            $this->open_db();
            $stm = $this->conn->prepare($query);
            $stm->execute($params);
            while ($rows[] = $stm->fetch(PDO::FETCH_ASSOC)); //resultados como array asociativo
            array_pop($rows); //elimino el ultimo dato
            $this->close_db();
            return $rows;
        } catch (PDOException $e) {
            $this->close_db();
            return [];
        }
    }

    protected function get_row($query, $params = array())
    {
        try {
            $this->open_db();
            $stm = $this->conn->prepare($query);
            $stm->execute($params);
            // Obtén solo el primer resultado
            $row = $stm->fetch(PDO::FETCH_ASSOC);
            $this->close_db();
            return $row; // Devuelve el primer resultado
        } catch (PDOException $e) {
            $this->close_db();
            return null; // Devuelve null si hay un error
        }
    }

    protected function execute($query, $params = array(), $returnLastInsertId = false)
    {
        try {
            $this->open_db();
            $stm = $this->conn->prepare($query);
            $stm->execute($params);

            if ($returnLastInsertId) {
                $lastInsertId = $this->conn->lastInsertId(); // Obtener el ID del último registro insertado
                $this->close_db();
                return $lastInsertId; // Devuelve el ID
            }

            $this->close_db();
            return true;
        } catch (PDOException $e) {
            $this->close_db();
            echo "Error: " . $e->getMessage();
            return false;
        }
    }
}
