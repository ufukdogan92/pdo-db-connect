<?php
function __autoload($className) {
    @define('BASE_PATH', realpath(dirname(__FILE__)));
    $file = BASE_PATH . '/' . str_replace('\\', '/', "class.".$className) . '.php';
    if(file_exists($file)) {
        require_once $file;
    }
}