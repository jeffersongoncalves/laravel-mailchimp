<?php

namespace JeffersonGoncalves\Mailchimp\Resources;

use JeffersonGoncalves\Mailchimp\MailchimpClient;

class Members
{
    public function __construct(
        protected MailchimpClient $client,
    ) {}

    public function list(string $listId, ?int $count = null, ?int $offset = null, ?string $status = null): array
    {
        return $this->client->get("/lists/{$listId}/members", [
            'count' => $count,
            'offset' => $offset,
            'status' => $status,
        ]);
    }

    /** @param string[]|null $tags */
    public function add(
        string $listId,
        string $email,
        ?string $status = 'subscribed',
        ?string $firstName = null,
        ?string $lastName = null,
        ?array $tags = null,
    ): array {
        return $this->client->post("/lists/{$listId}/members", $this->payload($email, $status, $firstName, $lastName, $tags));
    }

    /** @param string[]|null $tags */
    public function update(
        string $listId,
        string $subscriberHash,
        ?string $status = null,
        ?string $firstName = null,
        ?string $lastName = null,
        ?array $tags = null,
    ): array {
        return $this->client->patch("/lists/{$listId}/members/{$subscriberHash}", $this->payload(null, $status, $firstName, $lastName, $tags));
    }

    /**
     * @param  string[]|null  $tags
     * @return array<string, mixed>
     */
    protected function payload(?string $email, ?string $status, ?string $firstName, ?string $lastName, ?array $tags): array
    {
        return array_filter([
            'email_address' => $email,
            'status' => $status,
            'merge_fields' => array_filter([
                'FNAME' => $firstName,
                'LNAME' => $lastName,
            ]) ?: null,
            'tags' => $tags,
        ], fn ($value) => $value !== null);
    }
}
