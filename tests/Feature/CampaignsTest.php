<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Mailchimp\Exceptions\MailchimpException;
use JeffersonGoncalves\Mailchimp\Facades\Mailchimp;

it('lists campaigns', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/campaigns*' => Http::response(['campaigns' => [['id' => 'c1', 'type' => 'regular']]])]);

    $result = Mailchimp::campaigns()->list(10, 0, 'sent', 'regular');

    expect($result['campaigns'][0]['id'])->toBe('c1');
    Http::assertSent(fn ($request) => $request['status'] === 'sent' && $request['type'] === 'regular');
});

it('gets a single campaign', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/campaigns/c1' => Http::response(['id' => 'c1'])]);

    $result = Mailchimp::campaigns()->get('c1');

    expect($result['id'])->toBe('c1');
});

it('creates a campaign', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/campaigns' => Http::response(['id' => 'c1', 'type' => 'regular'])]);

    $result = Mailchimp::campaigns()->create('abc123', 'regular', 'Hello', 'Jane', 'jane@example.com', 'Welcome');

    expect($result['id'])->toBe('c1');
    Http::assertSent(fn ($request) => $request['recipients']['list_id'] === 'abc123'
        && $request['settings']['subject_line'] === 'Hello'
        && $request['settings']['from_name'] === 'Jane'
        && $request['settings']['reply_to'] === 'jane@example.com'
        && $request['settings']['title'] === 'Welcome');
});

it('sends a campaign', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/campaigns/c1/actions/send' => Http::response([], 204)]);

    $result = Mailchimp::campaigns()->send('c1');

    expect($result)->toBe([]);
    Http::assertSent(fn ($request) => $request->method() === 'POST');
});

it('throws on a failed campaign send', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/campaigns/c1/actions/send' => Http::response(['title' => 'Invalid Resource', 'detail' => 'The campaign cannot be sent'], 400)]);

    expect(fn () => Mailchimp::campaigns()->send('c1'))
        ->toThrow(MailchimpException::class, 'The campaign cannot be sent');
});
