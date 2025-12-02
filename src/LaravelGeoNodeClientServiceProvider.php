<?php

namespace EricAriyanto\LaravelGeoNodeClient;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use EricAriyanto\LaravelGeoNodeClient\Commands\LaravelGeoNodeClientCommand;

class LaravelGeoNodeClientServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-geonode-client')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_geonode_client_table')
            ->hasCommand(LaravelGeoNodeClientCommand::class);
    }
}
