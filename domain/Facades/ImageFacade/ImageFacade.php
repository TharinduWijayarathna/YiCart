<?php

namespace domain\Facades\ImageFacade;

use domain\Services\ImageService\ImageService;
use Illuminate\Support\Facades\Facade;

/**
 * Image Facade
 * php version 8
 *
 * @category Facade

 * */
class ImageFacade extends Facade
{
    /**
     * getFacadeAccessor
     *
     * @return void
     */
    protected static function getFacadeAccessor()
    {
        return ImageService::class;
    }
}
