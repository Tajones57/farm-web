<?php
require 'includes/config.php';
require_login();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: cart.php'); exit; }
$uid = $_SESSION['user_id'];
$s = $pdo->prepare('SELECT c.product_id, c.quantity, p.price FROM cart c JOIN products p ON p.id=c.product_id WHERE c.user_id=?');
$s->execute([$uid]);
$items = $s->fetchAll();
if (!$items) { header('Location: cart.php'); exit; }

$total = 0;
foreach ($items as $i) $total += $i['price'] * $i['quantity'];

$pdo->beginTransaction();
$pdo->prepare('INSERT INTO orders (user_id, total) VALUES (?,?)')->execute([$uid, $total]);
$oid = $pdo->lastInsertId();
$ins = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?,?,?,?)');
foreach ($items as $i) $ins->execute([$oid, $i['product_id'], $i['quantity'], $i['price']]);
$pdo->prepare('DELETE FROM cart WHERE user_id=?')->execute([$uid]);
$pdo->commit();

header('Location: done.php');
