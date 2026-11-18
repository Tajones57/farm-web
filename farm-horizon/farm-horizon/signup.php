<?php
require 'includes/config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = trim($_POST['email_or_phone'] ?? '');
    $pw = $_POST['password'] ?? '';
    if ($id === '' || strlen($pw) < 6) {
        $error = 'Enter your email/phone and a password with at least 6 characters.';
    } else {
        $c = $pdo->prepare('SELECT id FROM users WHERE email_or_phone=?');
        $c->execute([$id]);
        if ($c->fetch()) {
            $error = 'That email/phone is already registered.';
        } else {
            $pdo->prepare('INSERT INTO users (email_or_phone, password) VALUES (?,?)')
                ->execute([$id, password_hash($pw, PASSWORD_DEFAULT)]);
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['name'] = $id;
            header('Location: menu.php'); exit;
        }
    }
}
$title = 'Sign up - Farm Horizon';
require 'includes/header.php';
?>
<main class="auth signup">
  <img class="banner" src="images/banner-login.jpg" alt="Farm Horizon store">
  <div class="auth-body">
    <form method="post" class="auth-form">
      <?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
      <label>Email or Phone Number</label>
      <div class="field">
        <svg class="ico" viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg>
        <input type="text" name="email_or_phone" required value="<?= e($_POST['email_or_phone'] ?? '') ?>">
      </div>
      <label>Password</label>
      <div class="field">
        <svg class="ico toggle-pw" viewBox="0 0 24 24"><path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/><path d="M4 4l16 16"/></svg>
        <input type="password" name="password" id="pw" required>
      </div>
      <a href="#" class="forget">Forget Password?</a>
      <button class="btn-green square" type="submit">Sign up</button>
      <p class="or">Or Sign in With</p>
      <button type="button" class="btn-social"><svg viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9 3.5l6.7-6.7C35.6 2.4 30.2 0 24 0 14.6 0 6.5 5.4 2.6 13.2l7.8 6.1C12.3 13.6 17.7 9.5 24 9.5z"/><path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v9h12.7c-.6 3-2.3 5.5-4.8 7.2l7.5 5.8c4.4-4.1 7.1-10.1 7.1-17.5z"/><path fill="#FBBC05" d="M10.4 28.7c-.5-1.4-.8-3-.8-4.7s.3-3.2.8-4.7l-7.8-6.1C.9 16.3 0 20 0 24s.9 7.7 2.6 10.8l7.8-6.1z"/><path fill="#34A853" d="M24 48c6.2 0 11.4-2 15.2-5.5l-7.5-5.8c-2 1.4-4.7 2.3-7.7 2.3-6.3 0-11.7-4.1-13.6-9.8l-7.8 6.1C6.5 42.6 14.6 48 24 48z"/></svg><span>Sign In With Google</span></button>
      <button type="button" class="btn-social"><svg viewBox="0 0 24 24"><path d="M12 7.500c-2-1.500-6-.5-6 4.500 0 3.500 2.500 8 4.500 8 .8 0 1-.5 1.500-.5s.7.500 1.500.500c2 0 4.500-4.500 4.500-8 0-5-4-6-6-4.500z"/><path d="M12 7c0-2 1-3.500 3-4"/></svg><span>Sign In With Apple</span></button>
      <p class="switch">Already have an account? <a href="login.php">Log in</a></p>
    </form>
  </div>
</main>
<?php require 'includes/footer.php'; ?>
