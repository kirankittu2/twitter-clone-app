<?php
session_start();

const DSN = 'mysql:host=localhost;dbname=gesto';
const DB_USER = 'Kittu';
const DB_PASS = '996308179kk3';

$db;

try{
    $db = new PDO( DSN , DB_USER , DB_PASS  );
}catch(PDOException $e){
    die($e);
}


?>