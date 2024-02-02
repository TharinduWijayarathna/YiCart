<?php

namespace domain\Services\TaxService;

use App\Models\PosOrder;
use App\Models\PosOrderTax;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;

class TaxService
{
    protected $tax;
    protected $pos_order_tax;
    protected $pos_order;


    public function __construct()
    {
        $this->tax = new Tax();
        $this->pos_order_tax = new PosOrderTax();
        $this->pos_order = new PosOrder();
    }

    public function all()
    {
        return $this->tax->get();;
    }

    public function addTaxes(array $taxes, $order_id)
    {
        $pos_order_taxes = $this->pos_order_tax->where('order_id', $order_id)->get();
        foreach ($pos_order_taxes as $pos_order_tax) {
            $pos_order_tax->delete();
        }

        foreach ($taxes as $tax_id) {
            $tax = $this->tax->find($tax_id);

            $taxData['order_id'] = $order_id;
            $taxData['tax_id'] = $tax->id;
            $taxData['rate'] = $tax->rate;
            $this->pos_order_tax->create($taxData);
        }

        $this->refreshOrders($order_id);
    }

    public function showTaxes(int $order_id)
    {
        $taxes = $this->pos_order_tax->where('order_id', $order_id)->get();
        foreach ($taxes as $tax) {
            $order = $this->pos_order->where('id', $tax->order_id)->first();
            $tax_amount = ($tax->rate * ($order->sub_total - $order->discount)) / 100;
            $tax->tax_value = $tax_amount;
        }
        return $taxes;
    }

    public function removeTax(int $order_id, int $tax_id)
    {
        $tax = $this->pos_order_tax->where('order_id', $order_id)->where('tax_id', $tax_id)->first();
        if ($tax) {
            $tax->delete();
        }
        $this->refreshOrders($order_id);
    }

    public function refreshOrders($id)
    {
        $taxes = $this->pos_order_tax->where('order_id', $id)->get();

        if ($taxes->isEmpty()) {
            $order = $this->pos_order->where('id', $id)->first();
            $order->total_tax = 0;
            $order->update();
        }

        $tax_amount = 0;
        foreach ($taxes as $tax) {
            $order = $this->pos_order->where('id', $tax->order_id)->first();
            $tax_amount += ($tax->rate * ($order->sub_total - $order->discount)) / 100;
            $order->total_tax = $tax_amount;
            $order->update();
        }
    }
}
