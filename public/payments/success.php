<?php
declare(strict_types=1);
require_once __DIR__ . '/../../src/bootstrap.php';
$user = require_user($database);
if ((int) $user['has_access'] !== 1) redirect('/dashboard/');
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Payment complete</title><link rel="stylesheet" href="/assets/css/app.css"></head><body>
<main class="container"><section class="panel content"><div class="success-mark" aria-hidden="true">✓</div>
<h1>Payment verified</h1><p>The calculator is now available on your account.</p>
<a class="btn primary" href="/calculator/">Open the calculator</a></section></main></body></html>
