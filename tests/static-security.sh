#!/bin/sh
set -eu
root="$(CDPATH= cd -- "$(dirname -- "$0")/.." && pwd)"
! grep -R --line-number --include='*.php' 'SELECT.*\$username\|UPDATE.*\$email' "$root/public" "$root/src"
! grep -R --line-number --include='*.php' "DB_PASSWORD.*=.*'[^']\{4,\}'" "$root/public" "$root/src"
! grep -R --line-number 'eval(\|pyscript.net/latest' "$root/public" "$root/src"
grep -q 'paypal_request.*capture' "$root/public/payments/capture-order.php"
grep -q "has_access.*!== 1" "$root/public/calculator/index.php"
echo 'static-security: all checks passed'
