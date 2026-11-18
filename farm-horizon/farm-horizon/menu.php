<?php
require 'includes/config.php';
require_login();
$q = trim($_GET['q'] ?? '');
$cat = $_GET['cat'] ?? '';
$sql = 'SELECT * FROM products WHERE 1';
$args = [];
if ($q !== '') { $sql .= ' AND name LIKE ?'; $args[] = "%$q%"; }
if ($cat !== '') { $sql .= ' AND category = ?'; $args[] = $cat; }
$sql .= ' ORDER BY id';
$st = $pdo->prepare($sql); $st->execute($args);
$groups = [];
foreach ($st->fetchAll() as $p) $groups[$p['category']][] = $p;

$f = $pdo->prepare('SELECT product_id FROM favorites WHERE user_id=?');
$f->execute([$_SESSION['user_id']]);
$favs = array_column($f->fetchAll(), 'product_id');

$title = 'Farm Shop'; $show_nav = true; $active = 'home';
require 'includes/header.php';
?>
<main class="shop">
  <header class="shop-banner">
    <img src="images/banner-shop.jpg" alt="Welcome to Farm Horizon">
    <div class="shop-top"><button class="burger" aria-label="Menu"><span></span><span></span><span></span></button><b>FARM SHOP</b></div>
  </header>

  <div class="searchbar">
    <form method="get" class="search">
      <svg viewBox="0 0 24 24"><circle cx="10" cy="10" r="6"/><path d="M15 15l6 6"/></svg>
      <input type="text" name="q" value="<?= e($q) ?>" aria-label="Search">
    </form>
    <a href="cart.php" class="cart-ico" aria-label="Cart"><svg viewBox="0 0 24 24"><path d="M2 3h3l2.5 12h11L21 7H6"/><circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/></svg></a>
  </div>

  <?php if (!$groups): ?><p class="empty">No products found.</p><?php endif; ?>
  <?php foreach ($groups as $name => $items): ?>
    <section class="cat">
      <div class="cat-head"><h2><?= e($name) ?></h2><a href="menu.php?cat=<?= urlencode($name) ?>">See All</a></div>
      <div class="grid">
        <?php foreach ($items as $p): ?>
        <article class="card">
          <a href="product.php?id=<?= $p['id'] ?>" class="thumb"><img src="images/<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>"></a>
          <a href="favorite.php?id=<?= $p['id'] ?>" class="heart <?= in_array($p['id'], $favs) ? 'on' : '' ?>" aria-label="Favorite">
            <svg viewBox="0 0 24 24"><path d="M12 21s-8-5.500-8-11a4.500 4.500 0 018-2.800A4.500 4.500 0 0120 10c0 5.500-8 11-8 11z"/></svg></a>
          <a href="cart_action.php?do=add&id=<?= $p['id'] ?>&back=menu" class="plus" aria-label="Add to cart">+</a>
          <div class="info"><b><?= e($p['name']) ?></b><span><?= peso($p['price']) ?><?= $p['unit'] ? ' ' . e($p['unit']) : '' ?></span></div>
        </article>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>
</main>
<?php require 'includes/footer.php'; ?>
