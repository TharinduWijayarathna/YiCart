<?php

namespace domain\Services\PosOrderService;

use App\Models\BillPayment;
use App\Models\Customer;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\PosOrderTax;
use Illuminate\Support\Facades\Auth;
use domain\Facades\StockFacade\StockFacade;
use GuzzleHttp\Psr7\Request;

/**
 * PosOrderService
 * php version 8
 *
 * @category Service
 * */
class PosOrderService
{
    private $pos_order;
    private $pos_order_item;
    private $bill_payment;
    private $customer;


    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->pos_order = new PosOrder();
        $this->pos_order_item = new PosOrderItem();
        $this->bill_payment = new BillPayment();
        $this->customer = new Customer();
    }

    /**
     * All
     * retrieve all the data from PosOrder model
     *
     * @return void
     */
    public function all()
    {
        return $this->pos_order->all();
    }

    public function create()
    {
        $data['created_by'] = Auth::id();
        $count = $this->pos_order->count();

        $code = 'C' . sprintf('%05d', $count + 1);
        $check = $this->pos_order->getCode($code);

        while ($check) {
            $count++;
            $code = 'C' . sprintf('%05d',  $count);
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
        $order = $this->pos_order->getActiveOrder();
        if ($order) {
            return $order;
        } else {
            return $this->create();
        }
    }

    public function get(int $pos_order_id)
    {
        return $this->pos_order->find($pos_order_id);
    }

    public function selectProduct($product_data, $order_data)
    {
        $order_item = $this->pos_order_item->where('product_id', $product_data['id'])->where('order_id', $order_data['id'])->first();
        if (!empty($order_item)) {
            $order_item->quantity += 1;
            $order_item->sub_total = $order_item->quantity * $order_item['unit_price'];
            $order_item->total = $order_item->quantity * $order_item['unit_price'];
            $order_item->save();
        } else {
            $data = [
                'product_id' => $product_data['id'],
                'order_id' => $order_data['id'],
                'quantity' => 1,
                'unit_price' => $product_data['selling'],
                'sub_total' => 1 * $product_data['selling'],
                'total' => 1 * $product_data['selling'],
            ];
            $this->pos_order_item->create($data);
        }
    }

    public function getOrderProduct($order_data)
    {
        return $this->pos_order_item->getAll($order_data['id']);
    }

    public function clearOrder($order_id)
    {
        $this->pos_order_item->where('order_id', $order_id)->delete();
        $order = $this->pos_order->where('id', $order_id)->first();
        if ($order) {
            $order->discount = 0;
            $order->discount_type = null;
            $order->total_tax = 0;

            $order->save();
        }
    }

    public function getTotals($order_id)
    {
        $subTotal = $this->pos_order_item->subTotal($order_id);
        return $this->pos_order->updateTotals($order_id, $subTotal);
    }

    public function decreaseQty($product_data, int $order_id)
    {
        $order = $this->pos_order_item->where('product_id', $product_data['id'])->where('order_id', $order_id)->first();
        if ($order) {
            if ($order->quantity > 1) {
                $order->quantity -= 1;
                $order->sub_total = $order->quantity * $order['unit_price'];
                $order->total = $order->quantity * $order['unit_price'];
                $order->save();
            } else {
                $this->pos_order_item->where('product_id', $product_data['id'])->where('order_id', $order_id)->delete();
            }
        }
    }

    public function increaseQty($product_data, int $order_id)
    {
        $order = $this->pos_order_item->where('product_id', $product_data['id'])->where('order_id', $order_id)->first();
        if ($order) {
            $order->quantity += 1;
            $order->sub_total = $order->quantity * $order['unit_price'];
            $order->total = $order->quantity * $order['unit_price'];
            $order->save();
        }
    }

    public function updateQty($data, $product_data, int $order_id)
    {
        $order = $this->pos_order_item->where('product_id', $product_data['id'])->where('order_id', $order_id)->first();
        if ($order) {
            $order->quantity = $data['quantity'];
            $order->sub_total = $order->quantity * $order['unit_price'];
            $order->total = $order->quantity * $order['unit_price'];
            $order->save();
        }
    }

    public function changeUnitPrice($unit_price, $product_data, int $order_id)
    {
        $order = $this->pos_order_item->where('product_id', $product_data['id'])->where('order_id', $order_id)->first();
        if ($order) {
            $order->unit_price = $unit_price;
            $order->sub_total = $unit_price * $order['quantity'];
            $order->total = $unit_price * $order['quantity'];
            $order->save();
        }
    }

    public function removeItem($product_id, int $order_id)
    {
        $this->pos_order_item->where('product_id', $product_id)->where('order_id', $order_id)->delete();
    }

    public function customerUpdate(int $customer_id, int $order_id)
    {
        $order = $this->get($order_id);
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

    public function holdCart(int $order_id)
    {
        $order = $this->pos_order->where('id', $order_id)->first();
        if ($order) {
            $order->status = 2;
            $order->save();
        }
    }

    public function paymentDone($request)
    {
        $today = \Carbon\Carbon::now();
        $order = $this->pos_order->where('id', $request['order_id'])->first();
        $customer = $this->customer->where('id', $request['customer_id'])->first();
        if ($request['balance'] >= 0) {
            $order->credit_status = 1;
            $request['status'] = 1;
            $request['change'] =  $request['balance'];
            $request['accepted_amount'] = $request['paid_amount'] - $request['balance'];
            $order->customer_paid = $request['accepted_amount'];
            $request['balance'] =  0;
        } else if ($request['paid_amount'] == null) {
            $order->customer_paid = 0;
            $request['balance'] = abs($request['balance']);
            $customer->customer_outstanding = $customer->customer_outstanding + $request['balance'];
            $request['paid_amount'] = 0;
            $order->balance = $order->total;
            $request['accepted_amount'] = 0;
            $customer->save();
        } else {
            $order->customer_paid = $request['paid_amount'];
            $order->balance = $order->total - $request['paid_amount'];
            $request['balance'] =  $order->total - $request['paid_amount'];
            $customer->customer_outstanding = $customer->customer_outstanding + $request['balance'];
            $request['change'] =  0;
            $request['accepted_amount'] = $request['paid_amount'];
            $customer->save();
        }

        $order->status = 1;
        $order->save();

        $request['created_by'] = Auth::id();
        $count = $this->bill_payment->count();

        $code = 'B' . sprintf('%05d', $count + 1);
        $check = $this->bill_payment->getCode($code);

        while ($check) {
            $count++;
            $code = 'B' . sprintf('%05d',  $count);
            $check = $this->bill_payment->getCode($code);
        }

        $request['code'] = $code;
        $request['date'] = $today->toDateString();

        $this->bill_payment->create($request);
        StockFacade::productDecrease($request['order_id']);
    }

    public function discount(array $data)
    {
        $order = $this->pos_order->where('id', $data['orderId'])->first();
        if ($order) {
            if ($data['discountType'] == 1) {
                $order->discount = $data['discountAmount'];
                $order->discount_type = 0;
            }
            if ($data['discountType'] == 2) {
                $order->discount = $data['discountAmount'];
                $order->discount_type = 1;
            }
            $order->save();
        }
    }

    public function removeDiscount($order_id)
    {
        $order = $this->pos_order->where('id', $order_id)->first();
        if ($order) {
            $order->discount = 0;
            $order->discount_type = null;
            $order->save();
        }
    }

    public function reActive($order_id)
    {
        $previousOrder = $this->pos_order->where('created_by', Auth::user()->id)->where('status', 0)->first();
        if ($previousOrder->sub_total > 0) {
            $previousOrder->status = 2;
            $previousOrder->update();
        }
        $order = $this->pos_order->where('id', $order_id)->first();
        if ($order) {
            $order->status = 0;
            $order->save();
        }
    }

    public function deleteOrder($order_id)
    {
        return $this->pos_order->find($order_id)->delete();
    }

    public function returnUpdate(int $order_id)
    {
        $orderItem =  $this->get($order_id);
        if ($orderItem) {
            $orderItem->is_return = 1;
            $orderItem->save();
        }
    }
}
