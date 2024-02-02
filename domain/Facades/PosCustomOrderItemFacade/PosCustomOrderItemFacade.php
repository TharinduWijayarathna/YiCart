<?php

namespace domain\Facades\PosCustomOrderItemFacade;

use domain\Services\PosCustomOrderItemService\PosCustomOrderItemService;
use Illuminate\Support\Facades\Facade;

/**
 * PosCustomOrderItem Facade
 * php version 8
 *
 * @category Facade
 
 * */
class PosCustomOrderItemFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PosCustomOrderItemService::class;
    }
}
