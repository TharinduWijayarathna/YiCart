<?php

namespace domain\Facades\TaxFacade;

use domain\Services\TaxService\TaxService;
use Illuminate\Support\Facades\Facade;

class TaxFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TaxService::class;
    }
}
