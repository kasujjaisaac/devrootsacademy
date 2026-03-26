<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Student;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class PesapalService
{
    public function authenticate(): array
    {
        $cacheKey = 'pesapal.token.'.config('pesapal.environment');

        return Cache::remember($cacheKey, now()->addMinutes(4), function () {
            $response = $this->request()
                ->post($this->endpoint('/api/Auth/RequestToken'), [
                    'consumer_key' => config('pesapal.consumer_key'),
                    'consumer_secret' => config('pesapal.consumer_secret'),
                ])
                ->throw();

            $payload = $response->json();

            if (($payload['status'] ?? null) !== '200' || empty($payload['token'])) {
                throw new RuntimeException($payload['message'] ?? 'Pesapal authentication failed.');
            }

            return $payload;
        });
    }

    public function registerIpnUrl(): string
    {
        $cacheKey = 'pesapal.ipn_id.'.md5(config('pesapal.ipn_url').'|'.config('pesapal.ipn_method').'|'.config('pesapal.environment'));

        return Cache::rememberForever($cacheKey, function () {
            $response = $this->authenticatedRequest()
                ->post($this->endpoint('/api/URLSetup/RegisterIPN'), [
                    'url' => config('pesapal.ipn_url'),
                    'ipn_notification_type' => strtoupper(config('pesapal.ipn_method', 'GET')),
                ])
                ->throw();

            $payload = $response->json();

            if (($payload['status'] ?? null) !== '200' || empty($payload['ipn_id'])) {
                throw new RuntimeException($payload['error']['message'] ?? $payload['message'] ?? 'Pesapal IPN registration failed.');
            }

            return $payload['ipn_id'];
        });
    }

    public function submitOrder(Payment $payment, Student $student): array
    {
        $ipnId = $this->registerIpnUrl();

        [$firstName, $lastName] = $this->splitName($student->full_name);

        $response = $this->authenticatedRequest()
            ->post($this->endpoint('/api/Transactions/SubmitOrderRequest'), [
                'id' => $payment->merchant_reference,
                'currency' => $payment->currency ?: config('pesapal.currency', 'UGX'),
                'amount' => (float) $payment->amount,
                'description' => str($payment->description ?: 'DevRoots Academy course payment')->limit(100, '')->toString(),
                'callback_url' => config('pesapal.callback_url'),
                'redirect_mode' => 'TOP_WINDOW',
                'notification_id' => $ipnId,
                'branch' => config('pesapal.branch'),
                'billing_address' => [
                    'email_address' => $student->email,
                    'phone_number' => $student->phone,
                    'country_code' => config('pesapal.country_code', 'UG'),
                    'first_name' => $firstName,
                    'middle_name' => '',
                    'last_name' => $lastName,
                    'line_1' => $student->location ?: 'DevRoots Academy',
                    'line_2' => '',
                    'city' => '',
                    'state' => '',
                    'postal_code' => '',
                    'zip_code' => '',
                ],
            ])
            ->throw();

        $payload = $response->json();

        if (($payload['status'] ?? null) !== '200' || empty($payload['redirect_url']) || empty($payload['order_tracking_id'])) {
            throw new RuntimeException($payload['error']['message'] ?? $payload['message'] ?? 'Pesapal order submission failed.');
        }

        return $payload;
    }

    public function getTransactionStatus(string $orderTrackingId): array
    {
        $response = $this->authenticatedRequest()
            ->get($this->endpoint('/api/Transactions/GetTransactionStatus'), [
                'orderTrackingId' => $orderTrackingId,
            ])
            ->throw();

        $payload = $response->json();

        if (($payload['status'] ?? null) !== '200') {
            throw new RuntimeException($payload['error']['message'] ?? $payload['message'] ?? 'Pesapal transaction status lookup failed.');
        }

        return $payload;
    }

    protected function request(): PendingRequest
    {
        return Http::acceptJson()
            ->asJson()
            ->timeout(config('pesapal.timeout', 30));
    }

    protected function authenticatedRequest(): PendingRequest
    {
        $token = $this->authenticate()['token'] ?? null;

        if (! $token) {
            throw new RuntimeException('Pesapal bearer token could not be resolved.');
        }

        return $this->request()->withToken($token);
    }

    protected function endpoint(string $path): string
    {
        $baseUrl = config('pesapal.base_urls.'.config('pesapal.environment'));

        if (! $baseUrl) {
            throw new RuntimeException('Pesapal base URL is not configured.');
        }

        return rtrim($baseUrl, '/').$path;
    }

    protected function splitName(string $fullName): array
    {
        $parts = preg_split('/\s+/', trim($fullName)) ?: [];
        $firstName = $parts[0] ?? 'Student';
        $lastName = count($parts) > 1 ? end($parts) : 'DevRoots';

        return [$firstName, $lastName];
    }
}
