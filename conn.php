<?php
$dbhost = "127.0.0.1";
$dbport = 3306;
$dbname = "pdotest";
$dbuser = "root";
$dbpass = "123456";

try{
    $db = new PDO('mysql:host='.$dbhost.';port='.$dbport.';dbname='.$dbname,$dbuser,$dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $db->query('SET NAMES utf8;');
}catch (PDOException $e){
    echo '{"result":"failed","msg":"连接数据库失败!"}';
    exit;
}