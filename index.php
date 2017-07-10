<?php 
    include "includes/autoload.php"; 
    $mysql = new mysql("localhost","db", "user","password");
    $sqlserver = new sqlserver("localhost","db", "user","password");
    $postgresql = new postgresql("localhost","db", "user","password");
    
    $testMysql = $mysql->select("test","","","*");
    $testPg = $postgresql->select("test","","","*");
    $testSqlSrv = $sqlserver->select("test","","","*");
   
