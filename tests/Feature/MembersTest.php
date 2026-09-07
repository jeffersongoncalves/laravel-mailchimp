<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Mailchimp\Facades\Mailchimp;

it('lists members of a list', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/lists/abc123/members*' => Http::response(['members' => [['id' => 'm1', 'email_address' => 'jane@example.com']]])]);

    $result = Mailchimp::members()->list('abc123', 10, 0, 'subscribed');

    expect($result['members'][0]['email_address'])->toBe('jane@example.com');
    Http::assertSent(fn ($request) => $request['status'] === 'subscribed');
});

it('adds a member to a list', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/lists/abc123/members' => Http::response(['id' => 'm1', 'email_address' => 'jane@example.com'])]);

    $result = Mailchimp::members()->add('abc123', 'jane@example.com', 'subscribed', 'Jane', 'Doe', ['vip']);

    expect($result['email_address'])->toBe('jane@example.com');
    Http::assertSent(fn ($request) => $request['email_address'] === 'jane@example.com'
        && $request['status'] === 'subscribed'
        && $request['merge_fields']['FNAME'] === 'Jane'
        && $request['merge_fields']['LNAME'] === 'Doe'
        && $request['tags'] === ['vip']);
});

it('updates a member', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/lists/abc123/members/hash1' => Http::response(['id' => 'm1', 'status' => 'unsubscribed'])]);

    $result = Mailchimp::members()->update('abc123', 'hash1', 'unsubscribed');

    expect($result['status'])->toBe('unsubscribed');
    Http::assertSent(fn ($request) => $request->method() === 'PATCH' && $request['status'] === 'unsubscribed');
});
