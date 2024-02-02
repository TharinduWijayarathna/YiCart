<?php

namespace domain\Facades\PermissionFacade;

use domain\Services\PermissionService\PermissionService;
use Illuminate\Support\Facades\Facade;

/**
 * Permission Facade
 * php version 8
 *
 * @category Facade

 * */
class PermissionFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return PermissionService::class;
    }
}
