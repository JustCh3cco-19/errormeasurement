<?php
declare(strict_types=1);
require_once __DIR__ . '/../../src/bootstrap.php';
require_once __DIR__ . '/../../src/paypal.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') json_response(['error' => 'Method not allowed'], 405);
require_csrf();
$user = require_user($database);
if ((int) $user['has_access'] === 1) json_response(['error' => 'Access is already active'], 409);
try {
    $order = paypal_request('POST', '/v2/checkout/orders', [
        'intent' => 'CAPTURE',
        'purchase_units' => [[
            'custom_id' => (string) $user['id'],
            'description' => 'Error Measurement access',
            'amount' => ['currency_code' => 'EUR', 'value' => '2.00'],
        ]],
    ], bin2hex(random_bytes(16)));
    if (!isset($order['id']) || !is_string($order['id'])) {
        throw new RuntimeException('PayPal returned an invalid order.');
    }
    json_response(['id' => $order['id']]);
} catch (Throwable $error) {
    error_log($error->getMessage());
    json_response(['error' => 'Unable to create the payment'], 502);
}
