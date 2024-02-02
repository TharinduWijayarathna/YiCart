<?php

namespace domain\Facades\PosCashierDailyRecordFacade;

use domain\Services\PosCashierDailyRecordService\PosCashierDailyRecordService;
use Illuminate\Support\Facades\Facade;

/**
 * PosCashierDailyRecord Facade
 * php version 8
 *
 * @category Facade
 * 
 * */
class PosCashierDailyRecordFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PosCashierDailyRecordService::class;
    }
}
