<?php
// db.php — one connection, used by every page that needs the database.
// Same shape as Lab 4 (ereteti-sacco): settings live in config/config.php,
// the connection uses PDO prepared statements, and errors throw.
$config = require __DIR__ . '/../config/config.php';
try {
 $pdo = new PDO(
 "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
 $config['user'],
 $config['pass'],
 [
 PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
 ]
 );
} catch (PDOException $e) {
 die('Database connection failed: ' . $e->getMessage());
}
