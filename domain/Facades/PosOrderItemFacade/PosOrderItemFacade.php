<?php

namespace domain\Facades\PosOrderItemFacade;

use domain\Services\PosOrderItemService\PosOrderItemService;
use Illuminate\Support\Facades\Facade;

/**
 * PosOrderItem Facade
 * php version 8
 *
 * @category Facade

 * */
class PosOrderItemFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PosOrderItemService::class;
    }
}
