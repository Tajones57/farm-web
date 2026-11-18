<?php
require 'includes/config.php';
require_login();
$id = (int)($_GET['id'] ?? 0);
$s = $pdo->prepare('SELECT * FROM products WHERE id=?'); $s->execute([$id]);
$p = $s->fetch();
if (!$p) { header('Location: menu.php'); exit; }
$f = $pdo->prepare('SELECT 1 FROM favorites WHERE user_id=? AND product_id=?');
$f->execute([$_SESSION['user_id'], $id]);
$fav = (bool)$f->fetch();
$title = $p['name'] . ' - Details';
require 'includes/header.php';
?>
<main class="detail" data-price="<?= $p['price'] ?>">
  <a href="menu.php" class="back" aria-label="Back"><svg viewBox="0 0 24 24"><path d="M21 12H4M10 5l-7 7 7 7"/></svg></a>
  <h1 class="detail-title">Details</h1>
  <div class="detail-grid">
    <div class="detail-left">
      <img class="big" src="images/<?= e($p['detail_image'] ?: $p['image']) ?>" alt="<?= e($p['name']) ?>">
      <div class="name-row">
        <div><h2><?= e(strtoupper($p['name'])) ?></h2><p class="price"><?= peso($p['price']) ?></p></div>
        <div class="review"><b>Review</b><span><?= e($p['rating']) ?> ☆☆☆☆☆</span></div>
      </div>
    </div>
    <div class="detail-right">
      <a href="favorite.php?id=<?= $id ?>&back=product" class="heart big-heart <?= $fav ? 'on' : '' ?>" aria-label="Favorite"><svg viewBox="0 0 24 24"><path d="M12 21s-8-5.500-8-11a4.500 4.500 0 018-2.800A4.500 4.500 0 0120 10c0 5.500-8 11-8 11z"/></svg></a>
      <h3>Description</h3>
      <p class="desc"><?= e($p['description']) ?></p>

      <form method="post" action="cart_action.php" class="buy">
        <input type="hidden" name="do" value="add">
        <input type="hidden" name="id" value="<?= $id ?>">
        <div class="qty-row">
          <div class="qty"><span class="qty-val" id="qtyVal">1</span><button type="button" id="qtyPlus">+</button><button type="button" id="qtyMinus">-</button></div>
          <input type="hidden" name="qty" id="qtyInput" value="1">
          <div class="big-price" id="unitPrice"><?= peso($p['price']) ?></div>
        </div>
        <p class="total">TOTAL PRICE <b id="totalPrice"><?= peso($p['price']) ?></b></p>
        <div class="actions">
          <button type="submit" name="back" value="product" class="btn-cart" aria-label="Add to cart"><svg viewBox="0 0 24 24"><path d="M2 3h3l2.500 12h11L21 7H6"/><circle cx="9" cy="20" r="1.500"/><circle cx="17" cy="20" r="1.500"/><path d="M12 5v4M10 7h4"/></svg></button>
          <button type="submit" name="back" value="buy" class="btn-green pill">Buy now</button>
        </div>
      </form>
    </div>
  </div>
</main>
<?php require 'includes/footer.php'; ?>
