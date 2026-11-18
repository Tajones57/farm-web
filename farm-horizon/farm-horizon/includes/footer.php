<?php /* bottom nav: Home / Cart / User. Set $active = 'home'|'cart'|'user' */ ?>
<?php if (!empty($show_nav)): $n = cart_count($pdo); ?>
<nav class="bottom-nav">
  <a href="menu.php" class="<?= ($active ?? '')==='home'?'on':'' ?>">
    <svg viewBox="0 0 24 24"><path d="M3 11l9-8 9 8M5 10v10h5v-6h4v6h5V10"/></svg><span>Home</span></a>
  <a href="cart.php" class="<?= ($active ?? '')==='cart'?'on':'' ?>">
    <svg viewBox="0 0 24 24"><path d="M2 3h3l2.5 12h11L21 7H6"/><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/></svg>
    <span>Cart<?= $n ? " ($n)" : '' ?></span></a>
  <a href="account.php" class="<?= ($active ?? '')==='user'?'on':'' ?>">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="10" r="3"/><path d="M6 19c1.5-3 3.5-4 6-4s4.5 1 6 4"/></svg><span>User</span></a>
</nav>
<?php endif; ?>
<script src="js/script.js"></script>
</body>
</html>
