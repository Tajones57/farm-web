<?php
require 'includes/config.php';
require_login();
$s = $pdo->prepare('SELECT c.quantity, p.* FROM cart c JOIN products p ON p.id=c.product_id WHERE c.user_id=? ORDER BY c.id');
$s->execute([$_SESSION['user_id']]);
$items = $s->fetchAll();
$total = 0;
foreach ($items as $i) $total += $i['price'] * $i['quantity'];
$title = 'Cart'; $show_nav = true; $active = 'cart';
require 'includes/header.php';
?>
<main class="cart-page">
  <a href="menu.php" class="back" aria-label="Back"><svg viewBox="0 0 24 24"><path d="M21 12H4M10 5l-7 7 7 7"/></svg></a>
  <h1 class="detail-title">Cart</h1>

  <div class="cart-grid">
    <div class="cart-items">
      <?php if (!$items): ?><p class="empty">Your cart is empty. <a href="menu.php">Browse the shop</a></p><?php endif; ?>
      <?php foreach ($items as $i): ?>
      <div class="cart-item">
        <img src="images/<?= e($i['image']) ?>" alt="<?= e($i['name']) ?>">
        <div class="ci-info">
          <b><?= e($i['name']) ?></b>
          <span class="ci-price"><?= peso($i['price']) ?></span>
          <div class="qty small">
            <span class="qty-val"><?= (int)$i['quantity'] ?></span>
            <a href="cart_action.php?do=inc&id=<?= $i['id'] ?>">+</a>
            <a href="cart_action.php?do=dec&id=<?= $i['id'] ?>">-</a>
          </div>
        </div>
        <a href="cart_action.php?do=remove&id=<?= $i['id'] ?>" class="remove" aria-label="Remove">&#8855;</a>
      </div>
      <?php endforeach; ?>
    </div>

    <aside class="summary">
      <div class="line"><b>Order</b><b><?= peso($total) ?></b></div>
      <div class="line"><b>Total</b><b><?= peso($total) ?></b></div>
      <form method="post" action="checkout.php">
        <button class="btn-green pill" type="submit" <?= $items ? '' : 'disabled' ?>>Check Out</button>
      </form>
    </aside>
  </div>
</main>
<?php require 'includes/footer.php'; ?>
