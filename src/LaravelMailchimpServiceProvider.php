<?php

namespace Jeffersongoncalves\LaravelMailchimp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelMailchimpServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-mailchimp')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigrations();
    }
}
