<?php

namespace App\Http\Controllers;

use App\Http\Requests\PosOrderItem\UpdateQtyRequest;
use App\Http\Requests\PosOrderItem\UpdateUnitPriceRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use domain\Facades\ProductFacade\ProductFacade;
use domain\Facades\SalesPersonManagementFacade\SalesPersonManagementFacade;
use domain\Facades\TaxFacade\TaxFacade;
use Illuminate\Support\Facades\Auth;

/**
 * PosOrder Controller
 * php version 8
 *
 * @category Controller

 * */
class PosOrderController extends ParentController
{
    /**
     * index
     * Load Cart index with new Order details
     *
     * @return void
     */
    public function index()
    {

        $order = PosOrderFacade::getOrCreate();
        return redirect()->route('cart.process', $order->id);
    }

    /**
     * process
     *
     * @param  mixed $order_id
     * @return void
     */
    public function process($order_id)
    {
        $order = PosOrderFacade::get($order_id);
        if ($order->status == 1 || $order->created_by != Auth::id()) {
            $response['alert-danger'] = 'Order Can\'t be processed.';
            return redirect()->route('cart')->with($response);
        } else {
            $response['order'] = $order;
            return Inertia::render('Cart/index', $response);
        }
    }

    /**
     * edit
     * Get the details of created order for update data
     *
     * @param  mixed $order_id
     * @return void
     */
    public function edit(int $order_id)
    {

        $order = PosOrderFacade::get($order_id);
        return redirect()->route('cart.process', $order->id);
    }

    /**
     * cancel
     * To cancel created order
     *
     * @param  mixed $order_id
     * @return void
     */
    public function cancel(int $order_id)
    {
        PosOrderFacade::cancel($order_id);
    }

    /**
     * hold
     * To hold created order
     *
     * @param  mixed $order_id
     * @return void
     */
    public function hold(int $order_id)
    {
        PosOrderFacade::hold($order_id);
    }

    /**
     * update
     * To update created order
     *
     * @param  mixed $request
     * @return void
     */
    public function update(Request $request)
    {
        $order = PosOrderFacade::getOrCreate();
        return PosOrderFacade::customerUpdate($request->id, $order->id);
    }

    /**
     * finishGood
     * get all finish goods from material (for scan barcode )
     *
     * @param  string $barcode
     * @return void
     */
    public function finishGood(string $barcode)
    {
    }

    public function getFinishGood(int $product_id)
    {
    }

    /**
     * finishGoodAll
     * get all finish goods from material
     *
     *
     * @return void
     */
    public function finishGoodAll(Request $request)
    {
    }

    public function finishGoodByName(string $name)
    {
    }

    /**
     * discount
     * add discount to order
     *
     * @param  Request $request
     * @return void
     */
    public function discount(Request $request)
    {
        PosOrderFacade::discount($request->all());
    }

    public function removeDiscount(int $order_id)
    {
        PosOrderFacade::removeDiscount($order_id);
    }

    /**
     * get
     * get single POS order data using id
     *
     * @param  int $id
     * @return void
     */
    public function get(int $id)
    {
        return PosOrderFacade::get($id);
    }

    /**
     * salesPerson
     * det all sales people
     *
     * @return void
     */
    public function salesPerson()
    {
        // return SalesPersonManagementFacade::all();
    }

    public function getSalesPerson(int $id)
    {
        // return SalesPersonManagementFacade::get($id);
    }

    public function getByCode(string $bcode)
    {
        return PosOrderFacade::getByCode($bcode);
    }

    public function delete(int $id)
    {

        return PosOrderFacade::delete($id);
    }



    public function selectProduct($product_id)
    {
        $order = PosOrderFacade::getOrCreate();
        $product = ProductFacade::getById($product_id);
        return PosOrderFacade::selectProduct($product, $order);
    }

    public function getOrderProduct()
    {
        $order = PosOrderFacade::getOrCreate();
        return PosOrderFacade::getOrderProduct($order);
    }

    public function clearOrder()
    {
        $order = PosOrderFacade::getOrCreate();
        return PosOrderFacade::clearOrder($order->id);
    }

    public function getTotals()
    {
        $order = PosOrderFacade::getOrCreate();
        return PosOrderFacade::getTotals($order->id);
    }

    public function decreaseQty($product_id)
    {
        $order = PosOrderFacade::getOrCreate();
        $product = ProductFacade::getById($product_id);
        return PosOrderFacade::decreaseQty($product, $order->id);
    }

    public function increaseQty($product_id)
    {
        $order = PosOrderFacade::getOrCreate();
        $product = ProductFacade::getById($product_id);
        return PosOrderFacade::increaseQty($product, $order->id);
    }

    public function updateQty(UpdateQtyRequest $request, int $product_id)
    {
        $order = PosOrderFacade::getOrCreate();
        $product = ProductFacade::getById($product_id);
        return PosOrderFacade::updateQty($request, $product, $order->id);
    }

    public function changeUnitPrice(UpdateUnitPriceRequest $request)
    {
        $order = PosOrderFacade::getOrCreate();
        $product = ProductFacade::getById($request->product_id);
        return PosOrderFacade::changeUnitPrice($request->unit_price, $product, $order->id);
    }

    public function removeItem(int $product_id)
    {
        $order = PosOrderFacade::getOrCreate();
        return PosOrderFacade::removeItem($product_id, $order->id);
    }

    public function holdCart()
    {
        $order = PosOrderFacade::getOrCreate();
        return PosOrderFacade::holdCart($order->id);
    }

    public function removeCustomerId($order_id)
    {
        return PosOrderFacade::removeCustomerId($order_id);
    }

    public function paymentDone(Request $request)
    {
        return PosOrderFacade::paymentDone($request->all());
    }
}
