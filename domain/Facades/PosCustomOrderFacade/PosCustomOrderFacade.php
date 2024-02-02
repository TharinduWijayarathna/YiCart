<?php

namespace domain\Facades\PosCustomOrderFacade;

use domain\Services\PosCustomOrderService\PosCustomOrderService;
use Illuminate\Support\Facades\Facade;

/**
 * PosCustomOrder Facade
 * php version 8
 *
 * @category Facade
 * */
class PosCustomOrderFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PosCustomOrderService::class;
    }
}
