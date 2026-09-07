<?php

namespace JeffersonGoncalves\Mailchimp\Exceptions;

use Illuminate\Http\Client\Response;
use RuntimeException;

class MailchimpException extends RuntimeException
{
    /** @var array<string, mixed> */
    protected array $errorBody = [];

    public static function fromResponse(Response $response): self
    {
        $body = (array) ($response->json() ?? []);

        $message = $body['detail']
            ?? $body['title']
            ?? "Mailchimp API error (HTTP {$response->status()}).";

        $exception = new self((string) $message, $response->status());
        $exception->errorBody = $body;

        return $exception;
    }

    /** @return array<string, mixed> */
    public function errorBody(): array
    {
        return $this->errorBody;
    }
}
