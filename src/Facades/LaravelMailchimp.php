<?php

namespace Jeffersongoncalves\LaravelMailchimp\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jeffersongoncalves\LaravelMailchimp\LaravelMailchimp
 */
class LaravelMailchimp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'laravel-mailchimp';
    }
}
