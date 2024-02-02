<?php

namespace domain\Facades\ReturnFacade;

use domain\Services\ReturnService\ReturnService;
use Illuminate\Support\Facades\Facade;

class ReturnFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ReturnService::class;
    }
}
