<?php
declare(strict_types=1);

function paypal_base_url(): string
{
    return env('PAYPAL_ENV', 'sandbox') === 'live'
        ? 'https://api-m.paypal.com'
        : 'https://api-m.sandbox.paypal.com';
}

function paypal_request(string $method, string $path, ?array $payload = null, ?string $requestId = null): array
{
    $clientId = env('PAYPAL_CLIENT_ID', '');
    $secret = env('PAYPAL_CLIENT_SECRET', '');
    if ($clientId === '' || $secret === '') throw new RuntimeException('PayPal is not configured.');

    $tokenCurl = curl_init(paypal_base_url() . '/v1/oauth2/token');
    curl_setopt_array($tokenCurl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials', CURLOPT_USERPWD => $clientId . ':' . $secret,
        CURLOPT_HTTPHEADER => ['Accept: application/json', 'Accept-Language: en_US'], CURLOPT_TIMEOUT => 15]);
    $tokenBody = curl_exec($tokenCurl); $tokenStatus = curl_getinfo($tokenCurl, CURLINFO_RESPONSE_CODE);
    if ($tokenBody === false || $tokenStatus !== 200) throw new RuntimeException('PayPal authentication failed.');
    $token = json_decode($tokenBody, true, 512, JSON_THROW_ON_ERROR)['access_token'] ?? '';

    $curl = curl_init(paypal_base_url() . $path);
    $headers = ['Authorization: Bearer ' . $token, 'Content-Type: application/json', 'Prefer: return=representation'];
    if ($requestId !== null) $headers[] = 'PayPal-Request-Id: ' . $requestId;
    curl_setopt_array($curl, [CURLOPT_RETURNTRANSFER => true, CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_HTTPHEADER => $headers, CURLOPT_TIMEOUT => 20]);
    if ($payload !== null) curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload, JSON_THROW_ON_ERROR));
    $body = curl_exec($curl); $status = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
    if ($body === false) throw new RuntimeException('PayPal is unreachable.');
    $decoded = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    if ($status < 200 || $status >= 300) {
        error_log('PayPal API error: ' . $body);
        throw new RuntimeException('PayPal rejected the operation.');
    }
    return $decoded;
}
