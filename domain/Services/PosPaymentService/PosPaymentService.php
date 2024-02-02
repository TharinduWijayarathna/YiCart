<?php

namespace domain\Services\PosPaymentService;

use App\Models\PosPayment;
use App\Models\CustomerType;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use Illuminate\Support\Facades\Auth;

/**
 * PosPaymentService
 * php version 8
 *
 * */
class PosPaymentService
{

    protected $pos_payment;
    protected $customer_type;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->pos_payment = new PosPayment();
        $this->customer_type = new CustomerType();
    }

    /**
     * All
     * retrieve all the data from PosPayment model
     *
     * @return void
     */
    public function all()
    {
        return  $this->pos_payment->all();
    }

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    public function store(array $data)
    {
        $user = Auth::user();
        $data['cashier_name'] = $user->name;
        $data['cashier_id'] =  Auth::id();
        // dd($data);
        if(isset($data['customer_id'])){
            $order['customer_type'] = 'loyalty-customer';
            $order['customer_id'] = $data['customer_id'];

        }else{
            $order['customer_type'] = 'walking-customer';
        }
        PosOrderFacade::done($data);
        return $this->pos_payment->create($data);
    }

    /**
     * Get
     * retrieve relevant data using pos_payment_id
     *
     * @param  int  $pos_payment_id
     * @return void
     */
    public function get(int $pos_payment_id)
    {
        return $this->pos_payment->find($pos_payment_id);
    }

    /**
     * getByOrderId
     *
     * @param  int $order_id
     * @return void
     */
    public function getByOrderId(int $order_id)
    {
        return $this->pos_payment->where('order_id', $order_id)->first();
    }


    /**
     * Update
     * update existing data using pos_payment_id
     *
     * @param  array $data
     * @param  int   $pos_payment_id
     * @return void
     */
    public function update(int $item_id, int $quantity)
    {
        $item = $this->get($item_id);
        $item->quantity = $quantity;
        $item->total = $item->quantity * $item->unit_price;
        $item->save();

        PosPaymentFacade::storeTotal($item->total, $item->order_id);
        return $item;
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  PosPayment $pos_payment
     * @param  array $data
     * @return void
     */
    protected function edit(PosPayment $pos_payment, array $data)
    {
        return array_merge($pos_payment->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using pos_payment_id
     *
     * @param  int   $pos_payment_id
     * @return void
     */
    public function delete(int $pos_payment_id)
    {
        return $this->pos_payment->find($pos_payment_id)->delete();
    }

    /**
     * getInvoicesByLocationAndTime
     *
     * @param  array $hours
     * @return void
     */
    public function getInvoicesByLocationAndTime($hours)
    {
        return  $this->pos_payment->getInvoicesByLocationAndTime($hours);
    }

    /**
     * getTotalInvoices
     *
     * @return void
     */
    public function getTotalInvoices()
    {
        return  $this->pos_payment->getTotalInvoices();
    }

    /**
     * getMonthlyInvoices
     *
     * @return void
     */
    public function getMonthlyInvoices()
    {
        return  $this->pos_payment->getMonthlyInvoices();
    }
}
