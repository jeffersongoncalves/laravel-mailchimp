<?php

namespace JeffersonGoncalves\Mailchimp\Resources;

use JeffersonGoncalves\Mailchimp\MailchimpClient;

class Automations
{
    public function __construct(
        protected MailchimpClient $client,
    ) {}

    public function list(?int $count = null, ?int $offset = null): array
    {
        return $this->client->get('/automations', [
            'count' => $count,
            'offset' => $offset,
        ]);
    }
}
