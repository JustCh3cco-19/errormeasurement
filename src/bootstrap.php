<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    $useSecureCookies = getenv('APP_SECURE_COOKIES') === '1'
        || (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'secure' => $useSecureCookies,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

function env(string $name, ?string $default = null): ?string
{
    $value = getenv($name);
    return $value === false ? $default : $value;
}

$databasePassword = env('DB_PASSWORD');
if ($databasePassword === null || $databasePassword === '') {
    http_response_code(503);
    exit('Database configuration is missing.');
}

try {
    $database = new mysqli(
        env('DB_HOST', 'database'),
        env('DB_USER', 'error_app'),
        $databasePassword,
        env('DB_NAME', 'error_measurement'),
        (int) env('DB_PORT', '3306')
    );
    $database->set_charset('utf8mb4');
} catch (mysqli_sql_exception $exception) {
    error_log('Database connection failed: ' . $exception->getMessage());
    http_response_code(503);
    exit('The service is temporarily unavailable.');
}

function escape(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function redirect(string $location): never
{
    header('Location: ' . $location, true, 303);
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function require_csrf(): void
{
    $token = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    if (!is_string($token) || !hash_equals(csrf_token(), $token)) {
        http_response_code(403);
        exit('Invalid request. Reload the page and try again.');
    }
}

function current_user(mysqli $database): ?array
{
    $id = $_SESSION['user_id'] ?? null;
    if (!is_int($id)) {
        return null;
    }
    $statement = $database->prepare('SELECT id, username, email, has_access FROM users WHERE id = ?');
    $statement->bind_param('i', $id);
    $statement->execute();
    $user = $statement->get_result()->fetch_assoc();
    return $user ?: null;
}

function require_user(mysqli $database, string $loginPath = '/index.php'): array
{
    $user = current_user($database);
    if ($user === null) {
        redirect($loginPath);
    }
    return $user;
}

function json_response(array $body, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($body, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    exit;
}
