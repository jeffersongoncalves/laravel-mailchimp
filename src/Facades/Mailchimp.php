<?php

namespace JeffersonGoncalves\Mailchimp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JeffersonGoncalves\Mailchimp\Mailchimp
 */
class Mailchimp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \JeffersonGoncalves\Mailchimp\Mailchimp::class;
    }
}
