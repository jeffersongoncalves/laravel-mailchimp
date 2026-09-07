<?php

namespace JeffersonGoncalves\Mailchimp\Resources;

use JeffersonGoncalves\Mailchimp\MailchimpClient;

class Campaigns
{
    public function __construct(
        protected MailchimpClient $client,
    ) {}

    public function list(?int $count = null, ?int $offset = null, ?string $status = null, ?string $type = null): array
    {
        return $this->client->get('/campaigns', [
            'count' => $count,
            'offset' => $offset,
            'status' => $status,
            'type' => $type,
        ]);
    }

    public function get(string $campaignId): array
    {
        return $this->client->get("/campaigns/{$campaignId}");
    }

    public function create(
        string $listId,
        ?string $type = 'regular',
        ?string $subject = null,
        ?string $fromName = null,
        ?string $replyTo = null,
        ?string $title = null,
    ): array {
        return $this->client->post('/campaigns', [
            'type' => $type,
            'recipients' => ['list_id' => $listId],
            'settings' => array_filter([
                'subject_line' => $subject,
                'from_name' => $fromName,
                'reply_to' => $replyTo,
                'title' => $title,
            ]),
        ]);
    }

    public function send(string $campaignId): array
    {
        return $this->client->post("/campaigns/{$campaignId}/actions/send");
    }
}
