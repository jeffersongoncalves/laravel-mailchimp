<?php

namespace JeffersonGoncalves\Mailchimp\Resources;

use JeffersonGoncalves\Mailchimp\MailchimpClient;

class Lists
{
    public function __construct(
        protected MailchimpClient $client,
    ) {}

    public function list(?int $count = null, ?int $offset = null): array
    {
        return $this->client->get('/lists', [
            'count' => $count,
            'offset' => $offset,
        ]);
    }

    public function get(string $listId): array
    {
        return $this->client->get("/lists/{$listId}");
    }
}
