<?php
declare(strict_types=1);
require_once __DIR__ . '/../../src/bootstrap.php';
$user = require_user($database);
$paypalClientId = env('PAYPAL_CLIENT_ID', '');
$paypalEnabled = $paypalClientId !== '' && env('PAYPAL_CLIENT_SECRET', '') !== '';
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard · Error Measurement</title><link rel="stylesheet" href="/assets/css/app.css"></head>
<body><main class="container"><section class="content panel">
  <h1>Hello, <span><?= escape($user['username']) ?></span></h1><p>Welcome to your dashboard.</p>
  <?php if ((int) $user['has_access'] === 1): ?>
    <a href="/calculator/" class="btn primary">Open the calculator</a>
  <?php elseif ($paypalEnabled): ?>
    <p class="muted">Unlock the calculator with a one-time €2.00 contribution.</p>
    <div id="payment-message" class="message hidden" role="alert"></div><div id="paypal-button-container" data-csrf-token="<?= escape(csrf_token()) ?>"></div>
    <script src="https://www.paypal.com/sdk/js?client-id=<?= rawurlencode($paypalClientId) ?>&currency=EUR&locale=en_US"></script>
    <script src="/assets/js/paypal-checkout.js" defer></script>
  <?php else: ?>
    <div class="message info">Payments are not configured. Set the PayPal variables described in the README.</div>
  <?php endif; ?>
  <form method="post" action="/auth/logout.php" class="inline-form"><input type="hidden" name="csrf_token" value="<?= escape(csrf_token()) ?>"><button class="btn" type="submit">Sign out</button></form>
</section></main></body></html>
