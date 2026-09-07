<?php

namespace JeffersonGoncalves\Mailchimp\Tests;

use JeffersonGoncalves\Mailchimp\MailchimpServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            MailchimpServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('mailchimp.api_key', 'test-key-us21');
    }
}
