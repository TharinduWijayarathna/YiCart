<?php

namespace App\Http\Controllers;

use domain\Facades\PosOrderFacade\PosOrderFacade;
use domain\Facades\ProductFacade\ProductFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PosCartController extends ParentController
{
    public function index()
    {
        $order = PosOrderFacade::getOrCreate();
        return redirect()->route('cart.process', $order->id);
    }

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

    public function finishGoodByNameBarcode(Request $request)
    {
        return ProductFacade::finishGoodByNameBarcode($request->name, $request->product_category_id);
    }
}
