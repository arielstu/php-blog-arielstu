<?php

abstract class Model
{
    private static $db_host = 'localhost';
    private static $db_user = 'root';
    private static $db_pass = '';
    private static $db_name = 'arielstu';

    private $conn;

    protected $query;

    protected $rows;

    protected $num_rows = 0;

    abstract protected function cre();
    abstract protected function upd();
    abstract protected function rea();
    abstract protected function del();

    private function db_open()
    {
        try {
            $this->conn = new PDO('mysql:host=' . self::$db_host . ';dbname=' . self::$db_name . '', self::$db_user, self::$db_pass);
            $this->conn->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            return false;
        }
    }

    private function db_close()
    {
        $this->conn = '';
    }

    protected function set_query($items)
    {
        $this->db_open();
        try {
            $statement = $this->conn->prepare($this->query);
            // var_dump($items);
            // echo '<br>';
            // var_dump($statement);
            $result = $statement->execute($items);
            $this->db_close();
            return $result;

        } catch (PDOException $e) {
            $this->db_close();
            return false;
        }
    }

    protected function get_query($items)
    {
        $this->db_open();
        try {
            $statement = $this->conn->prepare($this->query);
            $result = $statement->execute($items);
            if ($result) {
                $result = $statement->fetchAll();

                $this->rows = $result;

                $this->num_rows = count($result);
                $this->db_close();
                return true;
            } else {
                $this->db_close();
                return false;
            }
        } catch (PDOException $e) {
            $this->db_close();
            return false;
        }

    }
}