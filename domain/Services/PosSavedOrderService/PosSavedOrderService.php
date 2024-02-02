<?php

namespace domain\Services\PosSavedOrderService;

use App\Models\PosOrder;
use Illuminate\Support\Facades\Auth;

/**
 * PosSavedOrderService
 * php version 8
 *
 * @category Service
 * */
class PosSavedOrderService
{
    private $pos_order;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->pos_order = new PosOrder();
    }

    /**
     * All
     * retrieve all the data from PosOrder model
     *
     * @return void
     */
    public function all()
    {
        return $this->pos_order->where('created_by', Auth::user()->id)->where('status', 2)->orderBy('id', 'desc')->get();
    }


}
