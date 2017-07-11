<?php 
    include "includes/autoload.php"; 
    $mysql = new mysql("localhost","codein", "root");
    $sqlserver = new sqlserver("localhost","db", "user","password");
    $postgresql = new postgresql("localhost","db", "user","password");
    
    $testMysql = $mysql->select("about","","","*");
    $testPg = $postgresql->select("test","","","*");
    $testSqlSrv = $sqlserver->select("test","","","*");
   
    print_r($testMysql);
