<?php

namespace Ikbal\WisePayment;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WiseService
{
    protected string $apiUrl;
    protected string $apiToken;
    protected string $profileId;

    public function __construct()
    {
        $this->apiUrl = config('wise.api_url');
        $this->apiToken = config('wise.api_token');
        $this->profileId = config('wise.profile_id');
    }

    private function headers(): array
    {
        return [
            'Authorization' => "Bearer {$this->apiToken}",
            'Content-Type'  => 'application/json',
        ];
    }

    public function createQuote(float $amount, string $sourceCurrency = 'USD', string $targetCurrency = 'EUR'): array
    {
        return Http::withHeaders($this->headers())->post("{$this->apiUrl}/v1/quotes", [
            'profile' => $this->profileId,
            'sourceCurrency' => $sourceCurrency,
            'targetCurrency' => $targetCurrency,
            'sourceAmount' => $amount,
        ])->json();
    }

    public function createRecipient(string $name, string $currency, string $iban): array
    {
        return Http::withHeaders($this->headers())->post("{$this->apiUrl}/v1/accounts", [
            'profile' => $this->profileId,
            'accountHolderName' => $name,
            'currency' => $currency,
            'type' => 'iban',
            'details' => [
                'iban' => $iban
            ]
        ])->json();
    }

    public function createTransfer(int $targetAccount, string $quoteId, ?string $transactionId = null): array
    {
        return Http::withHeaders($this->headers())->post("{$this->apiUrl}/v1/transfers", [
            'targetAccount' => $targetAccount,
            'quoteUuid' => $quoteId,
            'customerTransactionId' => $transactionId ?? (string) Str::uuid(),
        ])->json();
    }

    public function fundTransfer(int $transferId): array
    {
        return Http::withHeaders($this->headers())->post("{$this->apiUrl}/v3/profiles/{$this->profileId}/transfers/{$transferId}/payments", [
            'type' => 'BALANCE'
        ])->json();
    }
}