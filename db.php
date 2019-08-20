<?php

class DB
{
    private $USER = "root";
    private $PW = "admin";
    private $dns = "mysql:dbname=salesmanagement;host=mysql;charset=utf8";

    public function Connectdb()
    {
        try {
            $pdo = new PDO($this->dns, $this->USER, $this->PW);
            return $pdo;
        } catch (Exception $e) {
            return false;
        }
    }

    protected function executeSQL($sql, $array)
    {
        try {
            if (!$pdo = $this->Connectdb()) return false;
            $stmt = $pdo->prepare($sql);
            $stmt->execute($array);
            var_dump($stmt->queryString . '<br>');
            return $stmt;
        } catch (Exception $e) {
            return false;
        }
    }
}