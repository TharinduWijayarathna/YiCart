<?php

namespace domain\Services\PosCustomOrderService;

use App\Models\PosCustomOrder;
use App\Models\PosCustomOrderItem;
use App\Models\PosCustomOrderIssue;
use domain\Facades\PosCustomOrderFacade\PosCustomOrderFacade;
use domain\Facades\PosAdvanceReceiptFacade\PosAdvanceReceiptFacade;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use domain\Facades\CashierManagementFacade\CashierManagementFacade;

/**
 * PosCustomOrderService
 * php version 8
 *
 * @category Service
 * */
class PosCustomOrderService
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->order = new PosCustomOrder();
        $this->order_issue = new PosCustomOrderIssue();
        $this->order_items = new PosCustomOrderItem();
    }

    /**
     * All
     * retrieve all the data from PosCustomOrder model
     *
     * @return void
     */
    public function all()
    {
        return  $this->order->all();
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
        $count = $this->order->count();

        $order_no = 'CO' . sprintf('%05d', $count+1);
        $check = $this->order->where('order_no', $order_no)->first();

        while ($check)
        {
            $count++;
            $order_no = 'CO' . sprintf('%05d',  $count);
            $check = $this->order->where('order_no', $order_no)->first();
        }
        $data['payment_status'] = 0;
        $data['order_no'] = $order_no;
        $data['cashier_id'] = Auth::id();
        $cashier_id = Auth::id();
        $cashier = CashierManagementFacade::get($cashier_id);
        $data['location_id'] = $cashier->location_id;
        return $this->order->create($data);
        // $order =  $this->order->create($data);
        // $receipt_data['order_id'] = $order->id;
        // $stored_receipt = PosAdvanceReceiptFacade::store( $receipt_data);
        // $order['advanced_receipt_id'] = $stored_receipt->id;
        // $order['advanced_receipt_no'] = $stored_receipt->receipt_no;
        // $order->save();
        // return $order;
    }

    /**
     * Get
     * retrieve relevant data using order_id
     *
     * @param  int  $order_id
     * @return void
     */
    public function get(int $order_id)
    {
        return $this->order->find($order_id);
    }

    /**
     * updateTotal
     *
     * @param  mixed $order_id
     * @return void
     */
    public function updateTotal(int $order_id)
    {
        $order =  $this->order->find($order_id);
        $total =  $this->order_items->getTotal($order_id);
        $receipt_total = PosAdvanceReceiptFacade::getTotalByOrderId($order_id);
        if ($receipt_total != null) {
            $total = $total - $receipt_total;
        }
        $order->grand_total = $total;
        if ($receipt_total == null || $receipt_total == 0) {
            $order->payment_status = 0;
        }
        else if ($order->grand_total <=0) {
            $order->payment_status = 2;
        } else {
            $order->payment_status = 1;
        }
        $order->save();
    }

    /**
     * Update
     * update existing data using order_id
     *
     * @param  array $data
     * @param  int   $order_id
     * @return void
     */
    public function update(array $data, int $customer_id)
    {
        $customer = $this->order->find($customer_id);
        return $customer->update($this->edit($customer, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  PosCustomOrder $order
     * @param  array $data
     * @return void
     */
    protected function edit(PosCustomOrder $order, array $data)
    {
        return array_merge($order->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using order_id
     *
     * @param  int   $order_id
     * @return void
     */
    public function delete(int $order_id)
    {
        return $this->order->find($order_id)->delete();
    }

    /**
     * getTotalByAdvanceReceipt
     *
     * @param  mixed $amount
     * @param  int $order_id
     * @return void
     */
    public function getTotalByAdvanceReceipt($amount, int $order_id)
    {
        $order =  $this->order->find($order_id);
        $total = $this->order_items->getTotal($order_id);
        $order->grand_total = $total - $amount;
        // dd($order);
        $order->save();
    }

    /**
     * approve
     *
     * @param  int $order_id
     * @return void
     */
    public function approve(int $order_id)
    {
        $order = $this->order->find($order_id);
        $order->status = 1;
        $order->save();
    }

    /**
     * reject
     *
     * @param  int $order_id
     * @return void
     */
    public function reject(int $order_id)
    {
        $order = $this->order->find($order_id);
        $order->status = 2;
        $order->save();
    }

    /**
     * reverse
     *
     * @param  int $order_id
     * @param  string $remark
     * @return void
     */
    public function reverse(int $order_id, string $remark)
    {
        $order = $this->order->find($order_id);
        $now = Carbon::now();
        $order->status = 3;
        if ($remark) {
            $order->status_remark = $remark;
        }
        $order->reverse_date = $now->toDateString();
        $order->status_change_person = Auth::id();
        $order->save();
    }

    /**
     * fillGrandTotal
     *
     * @return void
     */
    public function fillGrandTotal()
    {
        $orders = $this->order->get();
        foreach ($orders as $order) {
            $this->updateTotal($order->id);
        }
    }

    /**
     * storeIssue
     *
     * @param  mixed $data
     * @return void
     */
    public function storeIssue(array $data){
        $data['created_by'] = Auth::id();
        $stored_item = $this->order_issue->create($data);

        $item =  $this->order_items->find($data['order_item_id']);
        $item->issue_quantity = $item->issue_quantity + $data['quantity'];
        $item->save();

        return $stored_item;
    }

}
