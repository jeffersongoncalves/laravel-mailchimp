<?php

namespace JeffersonGoncalves\Mailchimp;

use JeffersonGoncalves\Mailchimp\Resources\Automations;
use JeffersonGoncalves\Mailchimp\Resources\Campaigns;
use JeffersonGoncalves\Mailchimp\Resources\Lists;
use JeffersonGoncalves\Mailchimp\Resources\Members;
use JeffersonGoncalves\Mailchimp\Resources\Reports;

/**
 * Entry point exposing one resource per Mailchimp Marketing API group.
 */
class Mailchimp
{
    protected MailchimpClient $client;

    public function __construct(string $apiKey)
    {
        $this->client = new MailchimpClient($apiKey);
    }

    public function lists(): Lists
    {
        return new Lists($this->client);
    }

    public function members(): Members
    {
        return new Members($this->client);
    }

    public function campaigns(): Campaigns
    {
        return new Campaigns($this->client);
    }

    public function reports(): Reports
    {
        return new Reports($this->client);
    }

    public function automations(): Automations
    {
        return new Automations($this->client);
    }
}
