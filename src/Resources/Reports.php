<?php

namespace JeffersonGoncalves\Mailchimp\Resources;

use JeffersonGoncalves\Mailchimp\MailchimpClient;

class Reports
{
    public function __construct(
        protected MailchimpClient $client,
    ) {}

    public function get(string $campaignId): array
    {
        return $this->client->get("/reports/{$campaignId}");
    }
}
