<?php

namespace domain\Facades\UserFacade;

use domain\Services\UserService\UserService;
use Illuminate\Support\Facades\Facade;

class UserFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserService::class;
    }
}
