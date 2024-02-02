<?php

namespace domain\Services\BillPaymentService;

use App\Models\BillPayment;
use Illuminate\Support\Facades\Auth;

/**
 * PosPaymentService
 * php version 8
 *
 * @category Service

 * */
class BillPaymentService
{

    protected $bill_payment;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->bill_payment = new BillPayment();
    }



    /**
     * Get
     * retrieve relevant data using pos_payment_id
     *
     * @param  int  $pos_payment_id
     * @return void
     */
    public function get(int $order_id)
    {
        return $this->bill_payment->where('order_id', $order_id)->first();
    }
    // public function getBills(int $order_id)
    // {
    //     return $this->bill_payment->where('order_id', $order_id)->get();
    // }
}
