<?php

namespace domain\Services\ReturnService;

use App\Models\PosOrder;
use App\Models\PosOrderItem;
use Illuminate\Support\Facades\Auth;

class ReturnService
{
    protected $pos_order;
    protected $pos_order_item;
    public function __construct()
    {
        $this->pos_order = new PosOrder();
        $this->pos_order_item = new PosOrderItem();
    }

    public function create()
    {
        $data['created_by'] = Auth::id();
        $data['is_return'] = 1;
        $count = $this->pos_order->count();

        $code = 'R' . sprintf('%05d', $count + 1);
        $check = $this->pos_order->getCode($code);

        while ($check) {
            $count++;
            $code = 'R' . sprintf('%05d',  $count);
            $check = $this->pos_order->getCode($code);
        }

        $data['code'] = $code;
        return $this->pos_order->create($data);
    }

    /**
     * getOrCreate
     *
     * @return void
     */
    public function getOrCreate()
    {
        $order = $this->pos_order->getReturnOrder();
        if ($order) {
            return $order;
        } else {
            return $this->create();
        }
    }

    public function getOrder($order_code)
    {
        return $this->pos_order->where('created_by', Auth::user()->id)->where('code', $order_code)->first();
    }
    public function get($order_code)
    {
        $order = $this->pos_order->where('created_by', Auth::user()->id)->where('code', $order_code)->first();
        if ($order) {
            return $this->pos_order_item->where('order_id', $order->id)->get();
        }
    }

    public function addItems($data, $id)
    {

        $data['product_id'] = $data['product_id'];
        $data['order_id'] = $id;
        $data['return_status'] = 1;
        $data['unit_price'] = $data['unit_price'];
        $data['sub_total'] = $data['quantity'] * $data['unit_price'];
        $data['total'] = $data['quantity'] * $data['unit_price'];
        $data['return_quantity'] = +$data['quantity'];
        $data['quantity'] = -$data['quantity'];

        $this->pos_order_item->create($data);
    }

    public function getReturnProduct($order_data)
    {
        return $this->pos_order_item->getAll($order_data['id']);
    }

    public function deleteItem(int $id)
    {
        return $this->pos_order_item->find($id)->delete();
    }

    public function getTotals($order_id)
    {
        return $this->pos_order_item->where('order_id', $order_id)->get()->sum('total');
    }

    public function customerUpdate(int $customer_id, int $order_id)
    {
        $order = $this->pos_order->where('id', $order_id)->first();
        if (isset($customer_id)) {
            $order['customer_type'] = 'loyalty-customer';
            $order['customer_id'] = $customer_id;
        }
        $order->save();
        return $order;
    }

    public function removeCustomerId($order_id)
    {
        $order = $this->pos_order->where('id', $order_id)->first();
        if ($order) {
            $order->customer_id = null;
            $order->customer_type = null;
            $order->save();
        }
        return $order;
    }

    public function returnDone($request)
    {
        $order = $this->pos_order->where('id', $request['order_id'])->first();

        $order->status = 4;
        $order->total =  -($request['order_total']);
        $order->sub_total =  -($request['order_total']);
        $order->remark =  $request['remark'];
        $order->created_by =  Auth::id();

        $order->save();
    }
}
