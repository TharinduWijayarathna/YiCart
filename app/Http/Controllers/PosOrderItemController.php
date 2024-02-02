<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Resources\DataResource;
use domain\Facades\PosOrderItemFacade\PosOrderItemFacade;
use domain\Facades\GiftVoucherFacade\GiftVoucherFacade;
use domain\Facades\MaterialFacade\MaterialFacade;

/**
 * PosOrderItem Controller
 * php version 8
 *
 * @category Controller
 *
 * */
class PosOrderItemController extends ParentController
{
    /**
     * all
     * Get order items according to the order id
     *
     * @param  int $order_id
     * @return void
     */
    public function all(int $order_id)
    {
        return PosOrderItemFacade::all($order_id);
    }

    /**
     * getMaterial
     * Get material details from "Material" table and store necessary data in Pos order item table
     *
     * @param  string $barcode
     * @param  Request $order
     * @return void
     */
    public function getMaterial(string $barcode, Request $order)
    {
        $material =  MaterialFacade::getByBarcode($barcode);
        if (!$material == null) {
            return PosOrderItemFacade::store($material, $order->all());
        }
    }

    /**
     * update
     * Update quantity and total price of the order item
     *
     * @param  int $item_id
     * @param  Request $cart
     * @return void
     */
    public function update(int $item_id, Request $cart)
    {
        PosOrderItemFacade::update($item_id, $cart->quantity);
    }

    /**
     * delete
     * Delete order item by order item id
     *
     * @param  int $item_id
     * @return void
     */
    public function delete(int $item_id)
    {
        PosOrderItemFacade::delete($item_id);
    }

    /**
     * total
     * get all order item total sum
     *
     * @param  int $order_id
     * @return void
     */
    public function total(int $order_id)
    {
        return PosOrderItemFacade::total($order_id);
    }

    public function discount(Request $request, int $order_id)
    {
        PosOrderItemFacade::discount($request->all(), $order_id);
    }

    public function voucher($code)
    {
        return GiftVoucherFacade::getVoucherByCode($code);
        // dd($data);
    }
}
