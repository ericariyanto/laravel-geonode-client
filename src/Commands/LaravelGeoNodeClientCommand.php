<?php

namespace EricAriyanto\LaravelGeoNodeClient\Commands;

use Illuminate\Console\Command;

class LaravelGeoNodeClientCommand extends Command
{
    public $signature = 'geonode-client';

    public $description = 'GeoNode Client Command';

    public function handle(): int
    {
        $this->comment('GeoNode Client Command');

        return self::SUCCESS;
    }
}
