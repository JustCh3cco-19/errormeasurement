<?php
declare(strict_types=1);
require_once __DIR__ . '/../../src/bootstrap.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $username = is_string($_POST['username'] ?? null) ? trim($_POST['username']) : '';
    $rawEmail = is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '';
    $email = filter_var($rawEmail, FILTER_VALIDATE_EMAIL);
    $password = is_string($_POST['password'] ?? null) ? $_POST['password'] : '';
    $confirmation = is_string($_POST['password_confirmation'] ?? null) ? $_POST['password_confirmation'] : '';

    if (!preg_match('/^[\p{L}\p{N}_. -]{3,40}$/u', $username)) $errors[] = 'The username must contain 3–40 valid characters.';
    if ($email === false) $errors[] = 'The email address is invalid.';
    if (strlen($password) < 12 || strlen($password) > 128) $errors[] = 'The password must contain 12–128 characters.';
    if ($password !== $confirmation) $errors[] = 'The passwords do not match.';

    if (!$errors) {
        $statement = $database->prepare('SELECT username, email FROM users WHERE username = ? OR email = ?');
        $statement->bind_param('ss', $username, $email);
        $statement->execute();
        foreach ($statement->get_result() as $row) {
            if (strcasecmp($row['username'], $username) === 0) $errors[] = 'Username already in use.';
            if (strcasecmp($row['email'], (string) $email) === 0) $errors[] = 'Email address already in use.';
        }
    }
    if (!$errors) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        try {
            $statement = $database->prepare('INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)');
            $statement->bind_param('sss', $username, $email, $hash);
            $statement->execute();
            redirect('/index.php?registered=1');
        } catch (mysqli_sql_exception $exception) {
            if ($exception->getCode() === 1062) $errors[] = 'Username or email address already in use.';
            else throw $exception;
        }
    }
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Register · Error Measurement</title><link rel="stylesheet" href="/assets/css/app.css"></head>
<body><main class="form-container"><form method="post" novalidate><h1>Register</h1>
<?php foreach ($errors as $error): ?><div class="message error" role="alert"><?= escape($error) ?></div><?php endforeach; ?>
<input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>">
<label>Username<input name="username" autocomplete="username" minlength="3" maxlength="40" value="<?= escape(is_string($_POST['username'] ?? null) ? $_POST['username'] : '') ?>" required></label>
<label>Email<input type="email" name="email" autocomplete="email" maxlength="254" value="<?= escape(is_string($_POST['email'] ?? null) ? $_POST['email'] : '') ?>" required></label>
<label>Password <small>(at least 12 characters)</small><input type="password" name="password" autocomplete="new-password" minlength="12" maxlength="128" required></label>
<label>Confirm password<input type="password" name="password_confirmation" autocomplete="new-password" required></label>
<button class="form-btn" type="submit">Create account</button><p><a href="/index.php">Back to sign in</a></p>
</form></main></body></html>
