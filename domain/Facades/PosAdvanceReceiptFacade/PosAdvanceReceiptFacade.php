<?php

namespace domain\Facades\PosAdvanceReceiptFacade;

use domain\Services\PosAdvanceReceiptService\PosAdvanceReceiptService;
use Illuminate\Support\Facades\Facade;

/**
 * PosAdvanceReceipt Facade
 * php version 8
 *
 * @category Facade
 *
 * */
class PosAdvanceReceiptFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PosAdvanceReceiptService::class;
    }
}
