<?php

namespace domain\Facades\ConfigurationFacade;

use domain\Services\ConfigurationService\ConfigurationService;
use Illuminate\Support\Facades\Facade;

class ConfigurationFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ConfigurationService::class;
    }
}
