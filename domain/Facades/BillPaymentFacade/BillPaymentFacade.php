<?php

namespace domain\Facades\BillPaymentFacade;

use domain\Services\BillPaymentService\BillPaymentService;
use Illuminate\Support\Facades\Facade;

/**
 * PosPayment Facade
 * php version 8
 *
 * @category Facade
 
 * */
class BillPaymentFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return BillPaymentService::class;
    }
}
