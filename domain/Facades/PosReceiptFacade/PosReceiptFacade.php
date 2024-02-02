<?php

namespace domain\Facades\PosReceiptFacade;

use domain\Services\PosReceiptService\PosReceiptService;
use Illuminate\Support\Facades\Facade;

/**
 * PosReceipt Facade
 * php version 8
 *
 * @category Facade

 * */
class PosReceiptFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PosReceiptService::class;
    }
}
