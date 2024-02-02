<?php

namespace domain\Facades\PosCustomerFacade;

use domain\Services\PosCustomerService\PosCustomerService;
use Illuminate\Support\Facades\Facade;

/**
 * PosCustomer Facade
 * php version 8
 *
 * @category Facade

 * */
class PosCustomerFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PosCustomerService::class;
    }
}
