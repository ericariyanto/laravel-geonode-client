<?php

namespace EricAriyanto\LaravelGeoNodeClient\Commands;

use Illuminate\Console\Command;

class LaravelGeoNodeClientCommand extends Command
{
    public $signature = 'laravel-geonode-client';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
