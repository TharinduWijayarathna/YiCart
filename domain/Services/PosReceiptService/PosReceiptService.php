<?php

namespace domain\Services\PosReceiptService;

use App\Models\BillPayment;
use App\Models\Customer;
use App\Models\PosOrder;
use App\Models\PosReceipt;
use Illuminate\Support\Facades\Auth;

/**
 * PosReceiptService
 * php version 8
 * */
class PosReceiptService
{

    protected $order;
    protected $pos_receipt;
    protected $bill_payment;
    protected $customer;
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->order = new PosOrder();
        $this->pos_receipt = new PosReceipt();
        $this->bill_payment = new BillPayment();
        $this->customer = new Customer();
    }

    /**
     * All
     * retrieve all the data from PosReceipt model
     *
     * @return void
     */
    public function all()
    {
        return $this->pos_receipt->all();
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
        return $this->pos_receipt->create($data);
    }

    /**
     * Get
     * retrieve relevant data using pos_receipt_id
     *
     * @param  int  $pos_receipt_id
     * @return void
     */
    public function get(int $pos_receipt_id)
    {
        return $this->pos_receipt->find($pos_receipt_id);
    }

    /**
     * GetBills
     * retrieve relevant data using order_id
     *
     * @param  int  $order_id
     * @return void
     */
    public function getBills($order_id)
    {
        return $this->bill_payment->where('order_id', $order_id)->get();
    }

    /**
     * Update
     * update existing data using pos_receipt_id
     *
     * @param  array $data
     * @param  int   $pos_receipt_id
     * @return void
     */
    public function update(array $data, int $pos_receipt_id)
    {
        $pos_receipt = $this->pos_receipt->find($pos_receipt_id);
        return $pos_receipt->update($this->edit($pos_receipt, $data));
    }

    public function creditPay(array $data, int $order_id)
    {
        $today = \Carbon\Carbon::now();
        $data['created_by'] = Auth::user()->id;

        $bill_payment = $this->bill_payment->where('order_id', $order_id)->latest()->first();
        $order = $this->order->where('id', $order_id)->first();
        $customer = $this->customer->where('id', $order->customer_id)->first();

        $count = $this->bill_payment->count();

        $code = 'B' . sprintf('%05d', $count + 1);
        $check = $this->bill_payment->getCode($code);

        while ($check) {
            $count++;
            $code = 'B' . sprintf('%05d',  $count);
            $check = $this->bill_payment->getCode($code);
        }

        $data['code'] = $code;

        if ($bill_payment->balance >= $data['balance']) {
            $data['paid_amount'] = $data['balance'];
            $customer->customer_outstanding = $customer->customer_outstanding - $data['balance'];
            $data['accepted_amount'] = $data['balance'];
            $data['balance'] = $bill_payment->balance - $data['balance'];
            $order->customer_paid = $order->customer_paid + $data['accepted_amount'];
        } else {
            $data['accepted_amount'] = $bill_payment->balance;
            $customer->customer_outstanding = $customer->customer_outstanding - $data['accepted_amount'];
            $data['paid_amount'] = $data['balance'];
            $data['change'] = $data['balance'] - $data['accepted_amount'];
            $data['balance'] = 0;
            $order->customer_paid = $order->customer_paid + $data['accepted_amount'];
        }

        if ($order->total == $order->customer_paid) {
            $order->credit_status = 1;
        }

        $data['order_id'] = $order_id;
        $data['order_total'] = $order->total;
        $data['customer_id'] = $order->customer_id;
        $data['date'] = $today->toDateString();

        $customer->save();
        $order->save();
        $this->bill_payment->create($data);
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  PosReceipt $pos_receipt
     * @param  array $data
     * @return void
     */
    protected function edit(PosReceipt $pos_receipt, array $data)
    {
        return array_merge($pos_receipt->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using pos_receipt_id
     *
     * @param  int   $pos_receipt_id
     * @return void
     */
    public function delete(int $pos_receipt_id)
    {
        return $this->pos_receipt->find($pos_receipt_id)->delete();
    }

    public function storeTotal(int $id)
    {
        $order = $this->get($id);
        $order->total = $order->items->sum('total');
        $order->sub_total = $order->items->sum('total');
        $order->save();
        return $order;
    }

    public function holdOrders()
    {
        $user = Auth::user();
        return $this->pos_receipt->holds($user->name);
    }

    public function cancel(int $pos_receipt_id)
    {
        $order = $this->get($pos_receipt_id);
        $order->status = 3;
        $order->save();

        return $order;
    }

    public function hold(int $pos_receipt_id)
    {
        $order = $this->get($pos_receipt_id);
        $order->status = 2;
        $order->save();

        return $order;
    }

    public function done(int $pos_receipt_id)
    {
        $order = $this->get($pos_receipt_id);
        $order->status = 1;
        $order->save();

        return $order;
    }

    public function customerUpdate(array $cart)
    {
        $order = $this->get($cart['order_id']);
        if (isset($cart['customer_id'])) {
            $order['customer_id'] = $cart['customer_id'];
        }
        if (isset($cart['customer_type_slug'])) {
            $order['customer_type'] = $cart['customer_type_slug'];
        }
        $order->save();
    }
}
