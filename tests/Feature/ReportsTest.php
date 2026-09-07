<?php

use Illuminate\Support\Facades\Http;
use JeffersonGoncalves\Mailchimp\Facades\Mailchimp;

it('gets a campaign report', function () {
    Http::fake(['us21.api.mailchimp.com/3.0/reports/c1' => Http::response(['id' => 'c1', 'opens' => ['opens_total' => 42]])]);

    $result = Mailchimp::reports()->get('c1');

    expect($result['opens']['opens_total'])->toBe(42);
});
