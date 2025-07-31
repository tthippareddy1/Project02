<?php
session_start();
$host = '127.0.0.1';
$user = 'root';
$pass = 'root';
$db   = 'fifteen_puzzle';
$opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4",$user,$pass,$opts);
?>

