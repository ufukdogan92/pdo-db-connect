<?php

namespace PdoDbConnect\PdoDbConnect;
use PDO;
class Mysql extends DbConnection
{
    public function __construct($host, $db, $user = "", $passwd = "")
    {
        $con = "mysql:host=" . $host . ";dbname=" . $db;
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        try {
            PDO::__construct($con, $user, $passwd, $options);

        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo 'error: ' . $this->error;
        }
    }

}