<?php

namespace domain\Services\PosAdvanceReceiptService;

use App\Models\PosAdvanceReceipt;
use App\Models\PosCustomOrder;
use domain\Facades\PosCustomOrderFacade\PosCustomOrderFacade;
use Illuminate\Support\Facades\Auth;


class PosAdvanceReceiptService
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->receipt = new PosAdvanceReceipt();
        $this->order = new PosCustomOrder();
    }

    /**
     * All
     * retrieve all the data from PosAdvanceReceipt model
     *
     * @return void
     */
    public function all()
    {
        return  $this->receipt->all();
    }

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    public function store(int $order_id, array $data)
    {
        $count = $this->receipt->count();

        $receipt_no = sprintf('%05d', $count+1);
        $check = $this->receipt->where('receipt_no', $receipt_no)->first();

        while ($check)
        {
            $count++;
            $receipt_no = sprintf('%05d',  $count);
            $check = $this->receipt->where('receipt_no', $receipt_no)->first();
        }
        $data['receipt_no'] = $receipt_no;
        $data['order_id'] = $order_id;
        $receipt =  $this->receipt->create($data);
        $order_data = $this->order->find($order_id);
        $order_data['advanced_receipt_id'] = $receipt->id;
        $order_data['advanced_receipt_no'] = $receipt->receipt_no;
        $order_data->save();
        PosCustomOrderFacade::updateTotal($data['order_id']);
        return $receipt;
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
        $order_data = $this->order->find($order_id);
        $data['order_id'] = $order_id;
        $stored_receipt = $this->store($data);
        $order_data['advanced_receipt_id'] = $stored_receipt->id;
        $order_data['advanced_receipt_no'] = $stored_receipt->receipt_no;
        $order_data->save();
        return $stored_receipt;
    }

    public function getById(int $order_id){
        return $this->receipt->getByOrderId($order_id);
    }

    /**
     * Update
     * update existing data using receipt_id
     *
     * @param  array $data
     * @param  int   $receipt_id
     * @return void
     */
    public function update(array $data, int $receipt_id)
    {
        $receipt = $this->receipt->find($receipt_id);
        if ($data['amount']) {
            PosCustomOrderFacade::getTotalByAdvanceReceipt($data['amount'], $data['order_id']);
        }
        return $receipt->update($this->edit($receipt, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  PosAdvanceReceipt $receipt
     * @param  array $data
     * @return void
     */
    protected function edit(PosAdvanceReceipt $receipt, array $data)
    {
        return array_merge($receipt->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using receipt_id
     *
     * @param  int   $receipt_id
     * @return void
     */
    public function delete(int $receipt_id)
    {
        return $this->receipt->find($receipt_id)->delete();
    }

    /**
     * getByOrderId
     *
     * @param  mixed $order_id
     * @return void
     */
    public function getByOrderId(int $order_id)
    {
        return $this->receipt->getByOrderId($order_id);
    }

    /**
     * getTotalByOrderId
     *
     * @param  mixed $order_id
     * @return void
     */
    public function getTotalByOrderId(int $order_id)
    {
        return $this->receipt->getTotalByOrderId($order_id);
    }

    /**
     * getAllByOrderId
     *
     * @param  mixed $order_id
     * @return void
     */
    public function list(int $order_id)
    {
        return $this->receipt->list($order_id);
    }

    /**
     * getAdvanceReceipt
     *
     * @param  mixed $order_id
     * @return void
     */
    public function getAdvanceReceipt(int $order_id)
    {
        return $this->receipt->getAdvanceReceipt($order_id);
    }
}
