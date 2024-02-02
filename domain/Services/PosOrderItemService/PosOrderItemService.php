<?php

namespace domain\Services\PosOrderItemService;

use App\Models\Stock;
use App\Models\PosOrder;
use App\Models\PosOrderItem;
use App\Models\Material;
use domain\Facades\StockFacade\StockFacade;
use domain\Facades\StockLogFacade\StockLogFacade;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

/**
 * PosOrderItemService
 * php version 8
 * */
class PosOrderItemService
{
    protected $pos_order_item;
    protected $pos_order;
    protected $voucher_item;
    protected $material;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->pos_order_item = new PosOrderItem();
        $this->pos_order = new PosOrder();
        // $this->material = new Material();
    }

    /**
     * All
     * retrieve all the data from PosOrderItem model
     *
     * @return void
     */
    public function all(int $order_id)
    {
        return  $this->pos_order_item->getAll($order_id);
    }

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     * @return void
     */
    public function store($material_data, array $order)
    {
        // laradump()->dump($material_data);
        $finish_good = $this->pos_order_item->where('fg_id', $material_data['id'])->where('order_id', $order['id'])->first();
        if ($finish_good) {
            $finish_good->quantity += $order['quantity'];
            $finish_good->total = $finish_good->quantity * $material_data['selling_price'];
            $finish_good->sub_total = $finish_good->quantity * $material_data['selling_price'];
            $finish_good->save();
        } else {
            $request['fg_id'] = $material_data['id'];
            $request['unit_price'] = $material_data['selling_price'];
            $request['order_id'] = $order['id'];
            $request['quantity'] = $order['quantity'];
            $request['total'] = $order['quantity'] * $material_data['selling_price'];
            $request['sub_total'] = $order['quantity'] * $material_data['selling_price'];
            if ($order['quantity'] < 0) {
                $request['return_status'] = 1;
            }
            $this->pos_order_item->create($request);
        }

        // dd($material_data);
        $user = Auth::user();
        $stock =  StockFacade::getStockByMaterialId($material_data['id']);
        if($stock){
            $stock->qty -= $order['quantity'];
            $stock->save();

            StockLogFacade::store([
                        'material_id' => $material_data['id'],
                        'sku' => $stock->sku,
                        'barcode' => $stock->barcode,
                        'qty' => $order['quantity'],
                        'remarks' => 'Sell the product',
                        'type' => 1,
                        'created_by' => $user->id,
                        'to_location_id' => $stock->location_id,
                        'to_bin_id' => $stock->bin_id,
                        'to_warehouse_id' => $stock->warehouse_id,
                    ]);
        }else{
            $stock =  Stock::create([
                'material_id' => $material_data['id'],
                'name' => $material_data['name'],
                'barcode' => $material_data['barcode'],
                'uom' => $material_data['stock_uom'],
                'qty' => -$order['quantity'],
            ]);
            StockLogFacade::store([
                        'material_id' => $material_data['id'],
                        'qty' => $order['quantity'],
                        'remarks' => 'Sell the product - But not in the stock',
                        'type' => 1,
                        'created_by' => $user->id,
                    ]);
        }

        $material = $this->material->find($material_data['id']);
        $material->selling_qty = $material->selling_qty + $order['quantity'];
        $material->save();
        StockFacade::updateTotal($stock->material_id);
        $order = $this->pos_order->find($order['id']);
        $order->sub_total = $this->total($order['id']);
        $order->total = $this->total($order['id']);
        $order->save();

        return $order;
    }

    public function storeVoucher(array $data, int $order_id)
    {
        // dd($data['data']['id']);
        $request['voucher_id'] = $data['id'];
        $request['unit_price'] = $data['amount'];
        $request['order_id'] = $order_id;
        $request['quantity'] = 1;
        $request['type'] = 1;
        $request['total'] = $data['amount'];
        $request['sub_total'] = $data['amount'];

        $this->pos_order_item->create($request);

        $item =  $this->voucher_item->find($data['id']);
        $item->status = 2;
        $item->issued_date = Carbon::now();
        $item->issued_invoice_id = $order_id;
        $item->save();

        $order = $this->pos_order->find($order_id);
        $order->sub_total = $this->total($order_id);
        $order->total = $this->total($order_id);
        $order->save();

        return $order;
    }

    /**
     * Get
     * retrieve relevant data using pos_order_item_id
     *
     * @param  int  $pos_order_item_id
     * @return void
     */
    public function get(int $pos_order_item_id)
    {
        return $this->pos_order_item->find($pos_order_item_id);
    }

    /**
     * Update
     * update existing data using pos_order_item_id
     *
     * @param  array $data
     * @param  int   $pos_order_item_id
     * @return void
     */
    public function update(int $item_id, int $quantity)
    {
        $item = $this->get($item_id);
        $item->quantity = $quantity;
        $item->total = $item->quantity * $item->unit_price;
        $item->sub_total = $item->quantity * $item->unit_price;
        $item->save();

        PosOrderFacade::storeTotal($item->order_id);
        return $item;
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  PosOrderItem $pos_order_item
     * @param  array $data
     * @return void
     */
    protected function edit(PosOrderItem $pos_order_item, array $data)
    {
        return array_merge($pos_order_item->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using pos_order_item_id
     *
     * @param  int   $pos_order_item_id
     * @return void
     */
    public function delete(int $pos_order_item_id)
    {
        $order_item = $this->pos_order_item->find($pos_order_item_id);

        if ($order_item->type == 1) {
            $item =  $this->voucher_item->find($order_item->voucher_id);
            $item->issued_date = null;
            $item->issued_invoice_id = null;
            $item->status = 0;
            $item->save();
        } else {
            $stock =  StockFacade::getStockByMaterialIdForCal($order_item->fg_id);
            if ($stock) {
                $stock->qty += $order_item->quantity;
                $stock->save();
                StockFacade::updateTotal($stock->material_id);

                StockLogFacade::store([
                        'material_id' => $order_item->fg_id,
                        'sku' => $stock->sku,
                        'barcode' => $stock->barcode,
                        'qty' =>  $order_item->quantity,
                        'remarks' => 'Remove product from the cart',
                        'type' => 1,
                        'created_by' => Auth::id(),
                        'to_location_id' => $stock->location_id,
                        'to_bin_id' => $stock->bin_id,
                        'to_warehouse_id' => $stock->warehouse_id,
                    ]);
            }
            $material = $this->material->find($order_item->fg_id);
            $material->selling_qty = $material->selling_qty - $order_item->quantity;
            $material->save();
        }

        $this->pos_order_item->find($pos_order_item_id)->delete();
        $order = $this->pos_order->find($order_item->order_id);
        $order->sub_total = $this->total($order_item->order_id);
        $order->total = $this->total($order_item->order_id);
        $order->save();
    }

    /**
     * total
     * Get total of all items according to the order id
     *
     * @param  int $pos_order_item_id
     * @return void
     */
    public function total(int $pos_order_item_id)
    {
        return $this->pos_order_item->total($pos_order_item_id);
    }

    public function discount(array $data, int $order_id)
    {
        if (isset($data['select_orders'])) {
            $sales_orders = $data['select_orders'];
            if (isset($data['amount'])) {
                $discount = $data['amount'];
                foreach ($sales_orders as $item_id) {
                    $order_item =  $this->get($item_id);
                    // dd($order_item);

                    if ($order_item->type == 0) {
                        $order_item->discount = $discount;
                        $order_item->sub_total = $order_item->total - $discount;
                        $order_item->discount_type = 0;
                        $order_item->discount_remark = $data['discount_remark'];
                        $order_item->save();
                    }
                }
            }
            if (isset($data['percentage'])) {
                $discount = $data['percentage'];
                foreach ($sales_orders as $item_id) {
                    $order_item =  $this->get($item_id);
                    if ($order_item->type == 0) {
                        $order_item->discount = $order_item->total * ($discount / 100);
                        $order_item->sub_total = $order_item->total - ($order_item->total * ($discount / 100));;
                        $order_item->discount_type = 1;
                        $order_item->discount_remark = $data['discount_remark'];
                        $order_item->save();
                    }
                }
            }
            PosOrderFacade::storeTotal($order_id);
            // PosOrderFacade::storeRemark($order_id, $data);
        }
    }

    public function returnUpdate(array $orderItems)
    {
        foreach ($orderItems as $item) {
            $orderItem =  $this->get($item['id']);
            if ($orderItem) {
                $orderItem->return_quantity  = $orderItem->return_quantity ? ($orderItem->return_quantity +$item['available_qty']) : $item['available_qty'];
                $orderItem->save();
                if ($orderItem->return_quantity >= $orderItem->quantity) {
                    $orderItem->return_status  = 1;
                    $orderItem->save();
                }
            }
        }
    }

    public function getReturnItem(int $order_id)
    {
        return $this->pos_order_item->getReturnItem($order_id);
    }
}
