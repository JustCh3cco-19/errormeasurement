<?php
declare(strict_types=1);
require_once __DIR__ . '/../src/bootstrap.php';

if (current_user($database) !== null) {
    redirect('/dashboard/');
}

$error = null;
$notice = isset($_GET['registered']) ? 'Registration complete. You can now sign in.' : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $rawEmail = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
    $email = filter_var($rawEmail, FILTER_VALIDATE_EMAIL);
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';

    if ($email === false || $password === '') {
        $error = 'Enter a valid email address and password.';
    } else {
        $attemptKey = hash('sha256', strtolower((string) $email) . '|' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown'));
        $database->query("DELETE FROM login_attempts WHERE attempted_at < NOW() - INTERVAL 1 DAY");
        $statement = $database->prepare('SELECT COUNT(*) AS total FROM login_attempts WHERE attempt_key = ? AND attempted_at > NOW() - INTERVAL 15 MINUTE');
        $statement->bind_param('s', $attemptKey); $statement->execute();
        if ((int) $statement->get_result()->fetch_assoc()['total'] >= 5) {
            http_response_code(429);
            $error = 'Too many attempts. Try again in 15 minutes.';
        } else {
        $statement = $database->prepare('SELECT id, username, email, password_hash FROM users WHERE email = ? LIMIT 1');
        $statement->bind_param('s', $email);
        $statement->execute();
        $user = $statement->get_result()->fetch_assoc();

        if ($user && password_verify($password, $user['password_hash'])) {
            $statement = $database->prepare('DELETE FROM login_attempts WHERE attempt_key = ?');
            $statement->bind_param('s', $attemptKey); $statement->execute();
            session_regenerate_id(true);
            $_SESSION['user_id'] = (int) $user['id'];
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            redirect('/dashboard/');
        }
        $statement = $database->prepare('INSERT INTO login_attempts (attempt_key) VALUES (?)');
        $statement->bind_param('s', $attemptKey); $statement->execute();
        usleep(350000);
        $error = 'Incorrect email address or password.';
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Propagate measurement uncertainty using variances and covariances.">
  <title>Sign in · Error Measurement</title><link rel="stylesheet" href="/assets/css/app.css">
</head>
<body><main class="form-container"><form method="post" novalidate>
  <h1>Error Measurement</h1><p class="muted">Sign in to calculate the uncertainty of a function.</p>
  <?php if ($error): ?><div class="message error" role="alert"><?= escape($error) ?></div><?php endif; ?>
  <?php if ($notice): ?><div class="message success" role="status"><?= escape($notice) ?></div><?php endif; ?>
  <input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>">
  <label>Email<input type="email" name="email" autocomplete="email" maxlength="254" required></label>
  <label>Password<input type="password" name="password" autocomplete="current-password" required></label>
  <button class="form-btn" type="submit">Sign in</button>
  <p>Need an account? <a href="/auth/register.php">Register</a></p>
</form></main></body></html>
