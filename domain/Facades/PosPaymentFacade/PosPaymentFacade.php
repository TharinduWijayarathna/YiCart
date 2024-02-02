<?php

namespace domain\Facades\PosPaymentFacade;

use domain\Services\PosPaymentService\PosPaymentService;
use Illuminate\Support\Facades\Facade;

/**
 * PosPayment Facade
 * php version 8
 *
 * @category Facade
 
 * */
class PosPaymentFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PosPaymentService::class;
    }
}
