<?php
require 'includes/config.php';
require_login();
$uid = $_SESSION['user_id'];
$in  = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $_GET;
$do  = $in['do'] ?? '';
$id  = (int)($in['id'] ?? 0);
$qty = max(1, (int)($in['qty'] ?? 1));
$back = $in['back'] ?? 'cart';

if ($do === 'add' && $id) {
    $pdo->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?,?,?)
                   ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)')
        ->execute([$uid, $id, $qty]);
} elseif ($do === 'inc' && $id) {
    $pdo->prepare('UPDATE cart SET quantity = quantity + 1 WHERE user_id=? AND product_id=?')->execute([$uid, $id]);
} elseif ($do === 'dec' && $id) {
    $pdo->prepare('UPDATE cart SET quantity = GREATEST(1, quantity - 1) WHERE user_id=? AND product_id=?')->execute([$uid, $id]);
} elseif ($do === 'remove' && $id) {
    $pdo->prepare('DELETE FROM cart WHERE user_id=? AND product_id=?')->execute([$uid, $id]);
}

switch ($back) {
    case 'menu':    $to = 'menu.php'; break;
    case 'product': $to = "product.php?id=$id"; break;
    default:        $to = 'cart.php';          // 'buy' and 'cart' both land on the cart
}
header("Location: $to");
