# Error Measurement

A PHP web application that calculates first-order uncertainty propagation for multivariable functions:

```text
Var(f) = ∇fᵀ Σ ∇f
```

The calculator supports up to ten variables, symbolic derivatives, variances and covariances, covariance-matrix validation, and JSON/CSV exports. Account access is protected by a PayPal payment that is verified by the server.

## Run locally

Docker and Docker Compose are required.

```bash
cp .env.example .env
# Replace DB_PASSWORD with a local password.
docker compose up --build
```

Open <http://localhost:8080>. MariaDB is initialized automatically from `database/001_schema.sql`, and its data persists in the `database_data` volume.

To start again with an empty database:

```bash
docker compose down
docker volume rm error-measurement_database_data
```

The second command permanently deletes local accounts and payment records.

## PayPal configuration

Create a REST application in the PayPal Developer Dashboard and add its credentials to `.env`:

```dotenv
PAYPAL_ENV=sandbox
PAYPAL_CLIENT_ID=your-application-client-id
PAYPAL_CLIENT_SECRET=your-application-secret
```

Use `PAYPAL_ENV=live` only in production over HTTPS, and set `APP_SECURE_COOKIES=1`. Payments remain explicitly disabled when either credential is absent. The backend creates and captures the €2.00 order, then grants access only after verifying the status, user, amount, and currency returned by PayPal.

## Use the calculator

1. Select the number of variables. Variables are assigned in order from `a` through `j`.
2. Enter a function such as `a * b / sqrt(c)`.
3. Enter each variable's value and variance.
4. Enter the covariances above the matrix diagonal.
5. Calculate the result and optionally export it as JSON or CSV.

Allowed operators are `+ - * / ^`. Allowed functions are `sin`, `cos`, `tan`, `exp`, `log`, `sqrt`, and `abs`. The application rejects covariance matrices that are not symmetric and positive semidefinite.

For example, with `f = a + b`, variances `1` and `4`, and covariance `1`, the propagated variance is `1 + 4 + 2·1 = 7`.

## Security model

- Passwords are stored with `password_hash`.
- Database operations use parameterized queries and unique constraints.
- The session ID is regenerated after sign-in.
- Session cookies use `HttpOnly`, `SameSite=Lax`, and `Secure` over HTTPS.
- State-changing requests require CSRF tokens.
- Failed sign-in attempts are rate-limited.
- Mathematical expressions are parsed into an AST and restricted to an allowlist.
- Calculator and payment-success routes are protected on the server.
- PayPal orders are created and captured on the server with idempotency keys.
- Credentials come exclusively from environment variables.
- The Apache image sends restrictive HTTP security headers.

In production, use strong database credentials, terminate TLS correctly, protect application logs, and keep Docker images and locked dependencies up to date. Math.js is installed from the lockfile and copied into the image; it is not loaded from a public CDN.

## Tests

```bash
npm ci
npm audit --omit=dev
npm run check
npm test
sh tests/static-security.sh
find public src -name '*.php' -print0 | xargs -0 -n1 php -l
docker compose config --quiet
# With the containers running:
sh tests/smoke.sh
```

The GitHub Actions workflow runs these checks on every push and pull request.

## Repository layout

```text
public/                 Apache document root
  assets/               Browser CSS and JavaScript
  auth/                 Registration and sign-out routes
  calculator/           Protected calculator page
  dashboard/            Authenticated account page
  payments/             PayPal API routes and success page
src/                    Private PHP bootstrap and PayPal client
database/               Versioned database schema
docker/                 Apache security configuration
tests/                  Numerical, symbolic, security, and smoke tests
```
