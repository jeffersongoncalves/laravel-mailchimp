<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Mailchimp\Facades\Mailchimp;

it('lists lists', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/lists*' => Http::response(['lists' => [['id' => 'abc123', 'name' => 'Newsletter']]])]);

    $result = Mailchimp::lists()->list(10, 0);

    expect($result['lists'][0]['name'])->toBe('Newsletter');
    Http::assertSent(fn ($request) => $request['count'] === 10 && $request['offset'] === 0);
});

it('gets a single list', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/lists/abc123' => Http::response(['id' => 'abc123', 'name' => 'Newsletter'])]);

    $result = Mailchimp::lists()->get('abc123');

    expect($result['name'])->toBe('Newsletter');
});
