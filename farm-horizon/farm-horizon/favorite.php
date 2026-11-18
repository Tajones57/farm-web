<?php
require 'includes/config.php';
require_login();
$id = (int)($_GET['id'] ?? 0);
$uid = $_SESSION['user_id'];
$c = $pdo->prepare('SELECT 1 FROM favorites WHERE user_id=? AND product_id=?');
$c->execute([$uid, $id]);
if ($c->fetch()) $pdo->prepare('DELETE FROM favorites WHERE user_id=? AND product_id=?')->execute([$uid, $id]);
else $pdo->prepare('INSERT INTO favorites (user_id, product_id) VALUES (?,?)')->execute([$uid, $id]);
$back = ($_GET['back'] ?? '') === 'product' ? "product.php?id=$id" : 'menu.php';
header("Location: $back");
