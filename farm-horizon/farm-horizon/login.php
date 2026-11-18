<?php
require 'includes/config.php';
if (!empty($_SESSION['user_id'])) { header('Location: menu.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['email_or_phone'] ?? '');
    $pw = $_POST['password'] ?? '';
    $s = $pdo->prepare('SELECT * FROM users WHERE email_or_phone=?');
    $s->execute([$id]);
    $u = $s->fetch();
    if ($u && password_verify($pw, $u['password'])) {
        $_SESSION['user_id'] = $u['id'];
        $_SESSION['name'] = $u['full_name'] ?: $u['email_or_phone'];
        header('Location: menu.php'); exit;
    }
    $error = 'Wrong email/phone or password.';
}
$title = 'Log in - Farm Horizon';
require 'includes/header.php';
?>
<main class="auth">
  <img class="banner" src="images/banner-login.jpg" alt="Farm Horizon store">
  <div class="auth-body">
    <h1 class="auth-title">Getting Started<br>Lets Login to Expole More</h1>
    <form method="post" class="auth-form">
      <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
      <label>Email or Phone Number:</label>
      <div class="field">
        <svg class="ico" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
        <input type="text" name="email_or_phone" required value="<?= e($_POST['email_or_phone'] ?? '') ?>">
      </div>
      <label>Password:</label>
      <div class="field">
        <input type="password" name="password" id="pw" required>
        <svg class="ico right toggle-pw" viewBox="0 0 24 24"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path d="M4 4l16 16"/></svg>
      </div>
      <a href="#" class="forget">Forget Password?</a>
      <button class="btn-green" type="submit">Log in</button>
      <p class="switch">Dont't Have an Account? <a href="signup.php">Sign Up</a></p>
    </form>
  </div>
</main>
<?php require 'includes/footer.php'; ?>
