<?php
require 'includes/config.php';
require_login();
$s = $pdo->prepare('SELECT * FROM users WHERE id=?'); $s->execute([$_SESSION['user_id']]);
$u = $s->fetch();
$name = $u['full_name'] ?: $u['email_or_phone'];

$o = $pdo->prepare('SELECT * FROM orders WHERE user_id=? ORDER BY id DESC LIMIT 10');
$o->execute([$_SESSION['user_id']]);
$orders = $o->fetchAll();
$show = $_GET['show'] ?? '';

$title = 'Customers account'; $show_nav = true; $active = 'user';
require 'includes/header.php';
?>
<main class="account">
  <section class="acc-head">
    <span class="acc-label">Customers account</span>
    <div class="avatar"><svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.500 3.500-7 8-7s8 2.500 8 7z"/></svg></div>
    <h1><?= e($name) ?></h1>
  </section>

  <div class="acc-body">
    <ul class="acc-menu">
      <li><a href="account.php?show=orders"><svg viewBox="0 0 24 24"><path d="M5 7h14l-1 13H6zM9 7a3 3 0 016 0"/><path d="M9.500 13l2 2 3.500-4"/></svg>Your Order</a></li>
      <li><a href="#"><svg viewBox="0 0 24 24"><path d="M6 17V11a6 6 0 0112 0v6l2 2H4z"/><path d="M10 21h4"/></svg>Notification</a></li>
      <li><a href="#"><svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="12" rx="2"/><path d="M9 10l6 4"/></svg>Coupons</a></li>
      <li><a href="#"><svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="13" rx="2"/><path d="M3 10h18"/></svg>Payment Method</a></li>
      <li><a href="#"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M9.500 9.500a2.500 2.500 0 115 .5c0 1.500-2.500 2-2.500 3.500M12 17h.01"/></svg>Get Help</a></li>
      <li><a href="#"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6 19c1.500-3 3.500-4 6-4s4.500 1 6 4"/></svg>About</a></li>
      <li><a href="logout.php"><svg viewBox="0 0 24 24"><path d="M10 4H5v16h5M9 12h11M16 8l4 4-4 4"/></svg>Logout</a></li>
    </ul>

    <?php if ($show === 'orders'): ?>
    <div class="orders">
      <h3>Your Orders</h3>
      <?php if (!$orders): ?><p>No orders yet.</p><?php endif; ?>
      <?php foreach ($orders as $r): ?>
        <div class="order-row"><span>#<?= $r['id'] ?> &middot; <?= e(date('M d, Y', strtotime($r['created_at']))) ?></span><b><?= peso($r['total']) ?></b><em><?= e($r['status']) ?></em></div>
      <?php endforeach; ?>
    </div>
    <?php endif; ?>
  </div>
</main>
<?php require 'includes/footer.php'; ?>
