<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReturnItems\AddItemsRequest;
use domain\Facades\PosOrderFacade\PosOrderFacade;
use domain\Facades\PosOrderItemFacade\PosOrderItemFacade;
use domain\Facades\ProductFacade\ProductFacade;
use domain\Facades\ReturnFacade\ReturnFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ReturnsController extends ParentController
{

    public function index()
    {
        $order = ReturnFacade::getOrCreate();
        return redirect()->route('cart.return.process', $order->id);
    }

    public function process($order_id)
    {
        $order = PosOrderFacade::get($order_id);
        if ($order->status == 1 || $order->created_by != Auth::id()) {
            $response['alert-danger'] = 'Order Can\'t be processed.';
            return redirect()->route('cart')->with($response);
        } else {
            $response['order'] = $order;
            return Inertia::render('Returns/index', $response);
        }
    }

    public function get(String $order_code)
    {
        return ReturnFacade::get($order_code);
    }

    public function getOrder(String $order_code)
    {
        return ReturnFacade::getOrder($order_code);
    }

    public function returnBill(Request $return_details)
    {
        $data['order_id'] = $return_details->order_id[0];
        $data['return_value'] = $return_details->return_value;
        $data['remark'] = $return_details->remark;
        PosOrderItemFacade::returnUpdate($return_details->orderItems);
        PosOrderFacade::returnUpdate($return_details->order_id[0]);

        // return ReturnFacade::store($data);

    }

    public function addItems(AddItemsRequest $request)
    {
        try {
            if ($request['quantity'] == 0) {
                return response()->json([
                    'message' => 'The quantity cannot be 0'
                ], 422);
            }

            $order = ReturnFacade::getOrCreate();
            return ReturnFacade::addItems($request->all(), $order->id);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Product add failed'
            ], 422);
        }
    }

    public function getReturnProduct()
    {
        $order = ReturnFacade::getOrCreate();
        return ReturnFacade::getReturnProduct($order);
    }

    public function deleteItem($id)
    {
        return ReturnFacade::deleteItem($id);
    }

    public function getTotals()
    {
        $order = ReturnFacade::getOrCreate();
        return ReturnFacade::getTotals($order->id);
    }

    public function setCustomer(Request $request)
    {
        $order = ReturnFacade::getOrCreate();
        return ReturnFacade::customerUpdate($request->id, $order->id);
    }

    public function returnOrder()
    {
        return ReturnFacade::getOrCreate();
    }

    public function removeCustomerId($order_id)
    {
        return ReturnFacade::removeCustomerId($order_id);
    }

    public function returnDone(Request $request)
    {
        return ReturnFacade::returnDone($request->all());
    }
}
