<?php

use PdoDbConnect\PdoDbConnect\Mysql;

include "../vendor/autoload.php";


$mysql = new Mysql("127.0.0.1", "db_name", "root", '');

$table = $mysql->select("table_name", "", "", "*");  // === $mysql->select("table_name")


print_r($table);
