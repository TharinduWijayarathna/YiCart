<?php

namespace domain\Facades\CategoryFacade;

use domain\Services\CategoryService\CategoryService;
use Illuminate\Support\Facades\Facade;

class CategoryFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return CategoryService::class;
    }
}
