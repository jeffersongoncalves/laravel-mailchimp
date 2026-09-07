<div class="filament-hidden">

![Laravel Mailchimp](https://raw.githubusercontent.com/jeffersongoncalves/laravel-mailchimp/main/art/banner.png)

</div>

# Laravel Mailchimp

[![Latest Version on Packagist](https://img.shields.io/packagist/v/jeffersongoncalves/laravel-mailchimp.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-mailchimp)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-mailchimp/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/jeffersongoncalves/laravel-mailchimp/actions?query=workflow%3ATests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/jeffersongoncalves/laravel-mailchimp/pint.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/jeffersongoncalves/laravel-mailchimp/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/jeffersongoncalves/laravel-mailchimp.svg?style=flat-square)](https://packagist.org/packages/jeffersongoncalves/laravel-mailchimp)
[![License](https://img.shields.io/packagist/l/jeffersongoncalves/laravel-mailchimp.svg?style=flat-square)](LICENSE.md)

A Laravel wrapper for the [Mailchimp Marketing API v3](https://mailchimp.com/developer/marketing/api/). Covers lists, members, campaigns, reports and automations through a simple, typed API built on Laravel's `Http` client.

## Features

- Lists: `list`, `get`
- Members: `list`, `add`, `update`
- Campaigns: `list`, `get`, `create`, `send`
- Reports: `get`
- Automations: `list`
- Datacenter is derived automatically from the API key suffix (e.g. `xxxx-us21` → `us21`)
- Throws `MailchimpException` (with the original API error body) on any non-2xx response

## Installation

You can install the package via composer:

```bash
composer require jeffersongoncalves/laravel-mailchimp
```

Publish the config file:

```bash
php artisan vendor:publish --tag=mailchimp-config
```

Set your Mailchimp API key in `.env`:

```env
MAILCHIMP_API_KEY=your-api-key-us21
```

Find (or generate) your API key under **Account > Extras > API keys**.

## Configuration

```php
// config/mailchimp.php
return [
    'api_key' => env('MAILCHIMP_API_KEY', ''),
];
```

## Usage

The package is resolved via the `Mailchimp` facade or by injecting `JeffersonGoncalves\Mailchimp\Mailchimp`. Each resource is exposed as a method returning a dedicated resource class.

### Lists

```php
use JeffersonGoncalves\Mailchimp\Facades\Mailchimp;

$lists = Mailchimp::lists()->list(count: 10, offset: 0);

$list = Mailchimp::lists()->get('abc123');
```

### Members

```php
$members = Mailchimp::members()->list('abc123', count: 10, offset: 0, status: 'subscribed');

Mailchimp::members()->add(
    listId: 'abc123',
    email: 'jane@example.com',
    status: 'subscribed',
    firstName: 'Jane',
    lastName: 'Doe',
    tags: ['vip'],
);

Mailchimp::members()->update(
    listId: 'abc123',
    subscriberHash: md5(strtolower('jane@example.com')),
    status: 'unsubscribed',
);
```

### Campaigns

```php
$campaigns = Mailchimp::campaigns()->list(count: 10, offset: 0, status: 'sent', type: 'regular');

$campaign = Mailchimp::campaigns()->get('c1');

Mailchimp::campaigns()->create(
    listId: 'abc123',
    type: 'regular',
    subject: 'Hello!',
    fromName: 'Jane',
    replyTo: 'jane@example.com',
    title: 'Welcome campaign',
);

Mailchimp::campaigns()->send('c1');
```

### Reports

```php
$report = Mailchimp::reports()->get('c1');
```

### Automations

```php
$automations = Mailchimp::automations()->list(count: 10, offset: 0);
```

### Error handling

Any non-2xx API response throws `JeffersonGoncalves\Mailchimp\Exceptions\MailchimpException`, which exposes the decoded error body:

```php
use JeffersonGoncalves\Mailchimp\Exceptions\MailchimpException;

try {
    Mailchimp::campaigns()->send('c1');
} catch (MailchimpException $e) {
    logger()->error($e->getMessage(), $e->errorBody());
}
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Jefferson Gonçalves](https://github.com/jeffersongoncalves)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
