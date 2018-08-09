<?php 
    include "vendor/autoload.php";
    $mysql = new Mysql("127.0.0.1","370732_mdpV2", "root",'');
    //$sqlserver = new SqlServer("localhost","db", "user","password");
    //$postgresql = new PostgreSQL("localhost","db", "user","password");

    $table = $mysql->select("table_name","","","*");  // === $mysql->select("table_name")
    //$testPg = $postgresql->select("table_name","","","*");
    //$testSqlSrv = $sqlserver->select("table_name","","","*");

    print_r($table);
