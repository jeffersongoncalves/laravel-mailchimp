<?php

namespace Jeffersongoncalves\LaravelMailchimp\Tests;

use Jeffersongoncalves\LaravelMailchimp\LaravelMailchimpServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [
            LaravelMailchimpServiceProvider::class,
        ];
    }
}
