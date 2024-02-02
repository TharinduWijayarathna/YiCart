<?php

namespace domain\Services\PosCustomOrderItemService;

use App\Models\PosCustomOrderItem;
use App\Models\PosCustomOrder;
use domain\Facades\PosCustomOrderItemFacade\PosCustomOrderItemFacade;
use domain\Facades\PosCustomOrderFacade\PosCustomOrderFacade;
use Illuminate\Support\Facades\Auth;

/**
 * PosCustomOrderItemService
 * php version 8
 *
 * */
class PosCustomOrderItemService
{
    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->order_item = new PosCustomOrderItem();
        $this->order = new PosCustomOrder();
    }

    /**
     * All
     * retrieve all the data from PosCustomOrderItem model
     *
     * @return void
     */
    public function all()
    {
        return  $this->order_item->all();
    }

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    public function store(array $data, int $order_id)
    {
        $data['total'] = $data['quantity'] * $data['unit_price'];
        $data['order_id'] = $order_id;
        $item = $this->order_item->create($data);
        PosCustomOrderFacade::updateTotal($order_id, $data['total']);
        return $item;
    }

    /**
     * Get
     * retrieve relevant data using order_item_id
     *
     * @param  int  $order_item_id
     * @return void
     */
    public function get(int $order_item_id)
    {
        return $this->order_item->find($order_item_id);
    }

    /**
     * Update
     * update existing data using order_item_id
     *
     * @param  array $data
     * @param  int   $order_item_id
     * @return void
     */
    public function update(array $data, int $customer_item_id)
    {
        $data['total'] = $data['quantity'] * $data['unit_price'];
        $customer = $this->order_item->find($customer_item_id);
        $item = $customer->update($this->edit($customer, $data));
        PosCustomOrderFacade::updateTotal($data['order_id'], $data['total']);
        return $item;

    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  PosCustomOrderItem $order_item
     * @param  array $data
     * @return void
     */
    protected function edit(PosCustomOrderItem $order_item, array $data)
    {
        return array_merge($order_item->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using order_item_id
     *
     * @param  int   $order_item_id
     * @return void
     */
    public function delete(int $order_item_id)
    {
        $order = $this->order_item->find($order_item_id);
        $deleted_order = $order->delete();
        PosCustomOrderFacade::updateTotal($order->order_id);
        return $deleted_order;
    }

    public function getByNumber(int $phone_number)
    {
        return $this->order_item->getByNumber($phone_number);
    }
}
