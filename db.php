<?php
session_start();



$url    = parse_url(getenv("DATABASE_URL"));
$host   = $url["host"];
$port   = isset($url["port"]) ? $url["port"] : 5432;   // default for Postgres
$user   = $url["user"];
$pass   = $url["pass"];
$dbname = ltrim($url["path"], "/");


// Use the pgsql driver
$dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";
$opts = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
  $pdo = new PDO($dsn, $user, $pass, $opts);
} catch (PDOException $e) {
  exit("DB Connection failed: " . $e->getMessage());
}


