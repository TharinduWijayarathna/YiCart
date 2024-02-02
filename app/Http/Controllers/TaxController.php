<?php

namespace App\Http\Controllers;

use domain\Facades\PosOrderFacade\PosOrderFacade;
use domain\Facades\TaxFacade\TaxFacade;
use Illuminate\Http\Request;

class TaxController extends ParentController
{
    public function all()
    {
        return TaxFacade::all();
    }

    public function addTaxes(Request $request)
    {
        $order = PosOrderFacade::getOrCreate();
        return TaxFacade::addTaxes($request->all(), $order->id);
    }

    public function showTaxes()
    {
        $order = PosOrderFacade::getOrCreate();
        return TaxFacade::showTaxes($order->id);
    }

    public function removeTax($tax_id)
    {
        $order = PosOrderFacade::getOrCreate();
        return TaxFacade::removeTax($order->id, $tax_id);
    }
}
