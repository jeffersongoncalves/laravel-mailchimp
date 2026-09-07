<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Mailchimp\Facades\Mailchimp;

it('lists automations', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/automations*' => Http::response(['automations' => [['id' => 'a1']]])]);

    $result = Mailchimp::automations()->list(10, 0);

    expect($result['automations'][0]['id'])->toBe('a1');
    Http::assertSent(fn ($request) => $request['count'] === 10 && $request['offset'] === 0);
});
