<?php
// ---- DATABASE SETTINGS (XAMPP default) ----
$DB_HOST = 'localhost';
$DB_NAME = 'farm_horizon';
$DB_USER = 'root';
$DB_PASS = '';

session_start();

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Database connection failed. Check includes/config.php and that you imported sql/database.sql. ' . $e->getMessage());
}

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
function peso($n) { return '₱' . rtrim(rtrim(number_format((float)$n, 2), '0'), '.'); }
function require_login() {
    if (empty($_SESSION['user_id'])) { header('Location: login.php'); exit; }
}
function cart_count($pdo) {
    if (empty($_SESSION['user_id'])) return 0;
    $s = $pdo->prepare('SELECT COALESCE(SUM(quantity),0) FROM cart WHERE user_id=?');
    $s->execute([$_SESSION['user_id']]);
    return (int)$s->fetchColumn();
}
