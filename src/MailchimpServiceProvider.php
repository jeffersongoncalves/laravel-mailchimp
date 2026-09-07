<?php

namespace JeffersonGoncalves\Mailchimp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class MailchimpServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('mailchimp')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(Mailchimp::class, function () {
            return new Mailchimp((string) config('mailchimp.api_key'));
        });
    }
}
