#!/bin/sh
set -eu
base_url="${BASE_URL:-http://localhost:8080}"
tmp_dir="$(mktemp -d)"
trap 'rm -rf "$tmp_dir"' EXIT
cookies="$tmp_dir/cookies"
suffix="$(date +%s)$$"
username="Smoke $suffix"
email="smoke-$suffix@example.test"

curl -fsS -c "$cookies" "$base_url/auth/register.php" > "$tmp_dir/register.html"
token="$(sed -n 's/.*name="csrf_token" value="\([^"]*\)".*/\1/p' "$tmp_dir/register.html" | head -n 1)"
test -n "$token"
status="$(curl -sS -o /dev/null -w '%{http_code}' -b "$cookies" -c "$cookies" \
  --data-urlencode "csrf_token=$token" --data-urlencode "username=$username" \
  --data-urlencode "email=$email" --data-urlencode 'password=correct-horse-battery' \
  --data-urlencode 'password_confirmation=correct-horse-battery' "$base_url/auth/register.php")"
test "$status" = 303

curl -fsS -b "$cookies" -c "$cookies" "$base_url/index.php" > "$tmp_dir/login.html"
token="$(sed -n 's/.*name="csrf_token" value="\([^"]*\)".*/\1/p' "$tmp_dir/login.html" | head -n 1)"
status="$(curl -sS -o /dev/null -w '%{http_code}' -b "$cookies" -c "$cookies" \
  --data-urlencode "csrf_token=$token" --data-urlencode "email=$email" \
  --data-urlencode 'password=correct-horse-battery' "$base_url/index.php")"
test "$status" = 303

curl -fsS -b "$cookies" "$base_url/dashboard/" | grep -q "$username"
unauthorized="$(curl -sS -o /dev/null -w '%{http_code}' "$base_url/calculator/")"
test "$unauthorized" = 303
unpaid="$(curl -sS -o /dev/null -w '%{http_code}' -b "$cookies" "$base_url/calculator/")"
test "$unpaid" = 303
csrf_rejected="$(curl -sS -o /dev/null -w '%{http_code}' -b "$cookies" -X POST "$base_url/auth/logout.php")"
test "$csrf_rejected" = 403
echo 'smoke: registration, login and access control passed'
