<?php

use JeffersonGoncalves\Mailchimp\MailchimpClient;

it('derives the datacenter base url from the api key suffix', function () {
    expect(MailchimpClient::resolveBaseUrl('abcd1234-us21'))->toBe('https://us21.api.mailchimp.com/3.0');
});

it('supports datacenter suffixes containing digits and letters', function () {
    expect(MailchimpClient::resolveBaseUrl('fake-test-key-with-dashes-us6'))->toBe('https://us6.api.mailchimp.com/3.0');
});
