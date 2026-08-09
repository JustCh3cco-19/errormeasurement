<?php
declare(strict_types=1);
require_once __DIR__ . '/../../src/bootstrap.php';
$user = require_user($database);
if ((int) $user['has_access'] !== 1) redirect('/dashboard/');
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="description" content="Calculate variance and standard deviation through linear uncertainty propagation.">
<title>Variance calculator · Error Measurement</title><link rel="stylesheet" href="/assets/css/app.css">
<script src="/vendor/math.js" defer></script><script src="/assets/js/calculator-core.js" defer></script><script src="/assets/js/calculator.js" defer></script></head>
<body><main class="calculator container"><section class="panel wide">
  <header class="page-header"><div><h1>Uncertainty propagation</h1><p class="muted">Linear calculation using a covariance matrix.</p></div><a class="btn" href="/dashboard/">Dashboard</a></header>
  <form id="calculator-form" novalidate>
    <div class="form-grid"><label>Number of variables<select id="variable-count" name="variable-count"></select></label>
    <label>Function<input id="expression" value="a + b" required aria-describedby="syntax-help"></label></div>
    <p id="syntax-help" class="help">Use variables <code>a</code> through <code>j</code>. Allowed functions: sin, cos, tan, exp, log, sqrt, abs. Use <code>^</code> for powers.</p>
    <h2>Values and variances</h2><div id="variables" class="variable-grid"></div>
    <h2>Covariances</h2><p class="help">The diagonal contains the variances. Complete the cells above it.</p>
    <div class="table-scroll"><table id="covariance-table"></table></div>
    <div id="form-error" class="message error hidden" role="alert"></div>
    <button class="form-btn" type="submit">Calculate</button>
  </form>
  <section id="result" class="result hidden" aria-live="polite"><h2>Result</h2>
    <dl><div><dt>Function</dt><dd id="expression-result"></dd></div><div><dt>Function value</dt><dd id="function-value"></dd></div><div><dt>Variance</dt><dd id="variance-result"></dd></div><div><dt>Standard deviation</dt><dd id="deviation-result"></dd></div></dl>
    <p id="formula-result" class="help"></p>
    <h3>Gradient</h3><div id="gradient-result" class="code-output"></div>
    <button id="download-json" class="btn" type="button">Download JSON</button><button id="download-csv" class="btn" type="button">Download CSV</button>
  </section>
</section></main></body></html>
