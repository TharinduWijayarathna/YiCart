<?php

namespace domain\Facades\ProductFacade;

use domain\Services\ProductService\ProductService;
use Illuminate\Support\Facades\Facade;

class ProductFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ProductService::class;
    }
}
