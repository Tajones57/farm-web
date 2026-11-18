<?php
require 'includes/config.php';
require_login();
$title = 'Order placed';
require 'includes/header.php';
?>
<main class="done">
  <a href="menu.php" class="back" aria-label="Back"><svg viewBox="0 0 24 24"><path d="M21 12H4M10 5l-7 7 7 7"/></svg></a>
  <div class="check"><svg viewBox="0 0 24 24"><path d="M5 12.500l4.500 4.500L19 7.500"/></svg></div>
  <h1>Thank you</h1>
  <h2>You have placed your<br>order successfully</h2>
  <a href="menu.php" class="btn-green pill">View more option</a>
</main>
<?php require 'includes/footer.php'; ?>
