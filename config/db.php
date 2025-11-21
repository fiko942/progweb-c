<?php
// Database connection using PDO
$dbHost = '103.150.190.87';
$dbName = 'music_platform';
$dbUser = 'music_platform';
$dbPass = 'officer123';

try {
    $dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4";
    $pdo = new PDO($dsn, $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Show a friendly message without exposing sensitive details
    die('Database connection failed. Please check configuration.');
}
