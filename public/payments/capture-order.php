<?php
declare(strict_types=1);
require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/paypal.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_response(['error' => 'Method not allowed'], 405);
require_csrf();
$user = require_user($database);
try {
    $input = json_decode(file_get_contents('php://input'), true, 512, JSON_THROW_ON_ERROR);
} catch (JsonException) {
    json_response(['error' => 'Invalid JSON request'], 422);
}
$orderId = is_array($input) && is_string($input['orderID'] ?? null) ? $input['orderID'] : '';
if (!preg_match('/^[A-Z0-9]{8,32}$/', $orderId)) json_response(['error' => 'Invalid order'], 422);
try {
    $order = paypal_request('POST', '/v2/checkout/orders/' . rawurlencode($orderId) . '/capture', null, hash('sha256', 'capture|' . $orderId));
    $unit = $order['purchase_units'][0] ?? [];
    $capture = $unit['payments']['captures'][0] ?? [];
    $amount = $capture['amount'] ?? [];
    $valid = ($order['status'] ?? '') === 'COMPLETED'
        && hash_equals((string) $user['id'], (string) ($unit['custom_id'] ?? ''))
        && ($capture['status'] ?? '') === 'COMPLETED'
        && ($amount['currency_code'] ?? '') === 'EUR'
        && ($amount['value'] ?? '') === '2.00';
    if (!$valid) throw new RuntimeException('Invalid order details.');

    $captureId = (string) $capture['id'];
    $database->begin_transaction();
    $transactionStarted = true;
    $statement = $database->prepare('INSERT INTO payments (user_id, paypal_order_id, paypal_capture_id, amount, currency, status) VALUES (?, ?, ?, 2.00, \'EUR\', \'COMPLETED\')');
    $statement->bind_param('iss', $user['id'], $orderId, $captureId);
    $statement->execute();
    $statement = $database->prepare('UPDATE users SET has_access = 1 WHERE id = ?');
    $statement->bind_param('i', $user['id']); $statement->execute();
    $database->commit();
    json_response(['status' => 'COMPLETED']);
} catch (Throwable $error) {
    if (!empty($transactionStarted)) $database->rollback();
    error_log($error->getMessage());
    json_response(['error' => 'Payment could not be verified'], 502);
}
