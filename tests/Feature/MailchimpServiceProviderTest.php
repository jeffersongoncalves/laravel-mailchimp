<?php

use JeffersonGoncalves\Mailchimp\Facades\Mailchimp as MailchimpFacade;
use JeffersonGoncalves\Mailchimp\Mailchimp;

it('registers the mailchimp singleton', function () {
    expect(app(Mailchimp::class))->toBeInstanceOf(Mailchimp::class);
});

it('resolves the facade to the mailchimp class', function () {
    expect(MailchimpFacade::getFacadeRoot())->toBeInstanceOf(Mailchimp::class);
});

it('merges the config file', function () {
    expect(config('mailchimp.api_key'))->toBe('test-key-us21');
});
