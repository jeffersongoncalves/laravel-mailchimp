<?php

namespace JeffersonGoncalves\Mailchimp;

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Mailchimp\Exceptions\MailchimpException;

/**
 * Thin wrapper around Laravel's Http client for the Mailchimp Marketing API
 * (https://mailchimp.com/developer/marketing/api/), authenticated with HTTP
 * Basic Auth (any username, API key as password).
 */
class MailchimpClient
{
    protected string $baseUrl;

    public function __construct(
        protected string $apiKey,
    ) {
        $this->baseUrl = self::resolveBaseUrl($apiKey);
    }

    /**
     * The datacenter (e.g. "us21") is the suffix after the last "-" in the
     * API key, and determines which regional host to call.
     */
    public static function resolveBaseUrl(string $apiKey): string
    {
        $datacenter = array_slice(explode('-', $apiKey), -1)[0];

        return "https://{$datacenter}.api.mailchimp.com/3.0";
    }

    /** @param array<string, mixed> $query */
    public function get(string $path, array $query = []): array
    {
        return $this->request('get', $path, array_filter($query, fn ($value) => $value !== null));
    }

    /** @param array<string, mixed>|null $body */
    public function post(string $path, ?array $body = null): array
    {
        return $this->request('post', $path, $body);
    }

    /** @param array<string, mixed>|null $body */
    public function patch(string $path, ?array $body = null): array
    {
        return $this->request('patch', $path, $body);
    }

    /** @param array<string, mixed>|null $data */
    protected function request(string $method, string $path, ?array $data = null): array
    {
        $response = Http::withBasicAuth('anystring', $this->apiKey)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->baseUrl($this->baseUrl)
            ->{$method}($path, $data ?? []);

        if ($response->failed()) {
            throw MailchimpException::fromResponse($response);
        }

        return (array) ($response->json() ?? []);
    }
}
