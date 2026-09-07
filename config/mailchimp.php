<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Find (or generate) your API key under Account > Extras > API keys.
    | The datacenter (e.g. "us21") is derived automatically from the suffix
    | after the last "-" in the key, so there is nothing else to configure.
    |
    */
    'api_key' => env('MAILCHIMP_API_KEY', ''),

];
