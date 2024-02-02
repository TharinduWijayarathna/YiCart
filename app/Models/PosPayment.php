<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PosPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'cashier_name',
        'customer_id',
        'cashier_id',
        'customer_type',
        'card',
        'cash',
        'visa',
        'credit',
        'amex',
        'voucher',
        'total_amount',
        'payed_amount',
        'return_amount',
    ];

    /**
     * getTotalInvoices
     *
     * @return void
     */
    public function getTotalInvoices()
    {
        $id = Auth::id();
        $cashier = Cashier::where('id', $id)->first();
        $cashier_ids = Cashier::where('location_id', $cashier->location_id)->pluck('id')->toArray();
        $date = Carbon::now();
        return $this->whereIn('cashier_id', $cashier_ids)->whereDate('created_at', $date)->count();
        // $date = Carbon::now();
        // return $this->whereDate('created_at', $date)->count();
    }

    /**
     * getInvoicesByLocationAndTime
     *
     * @param  array $hours
     * @return void
     */
    public function getInvoicesByLocationAndTime($hours)
    {
        $id = Auth::id();
        $cashier = Cashier::where('id', $id)->first();
        $cashier_ids = Cashier::where('location_id', $cashier->location_id)->pluck('id')->toArray();
        $full_date = Carbon::now();
        $date = $full_date->toDateString();
        foreach ($hours as $key => $hour) {
            $startTime = $date . ' ' . $hour . ':00:00';
            $endTime = $date . ' ' . $hour . ':59:59';
            $data[] = $this->whereIn('cashier_id', $cashier_ids)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->count();
        }
        return $data;
        // $cashier_ids = Cashier::where('location_id', $location_id)->pluck('id')->toArray();
        // $full_date = Carbon::now();
        // $date = $full_date->toDateString();
        // foreach ($hours as $key => $hour) {
        //     $startTime = $date . ' ' . $hour . ':00:00';
        //     $endTime = $date . ' ' . $hour . ':59:59';
        //     $data[] = $this->whereIn('cashier_id', $cashier_ids)->where('created_at', '>=', $startTime)->where('created_at', '<=', $endTime)->count();
        // }
        // return $data;
    }

    /**
     * getMonthlyInvoices
     *
     * @return void
     */
    public function getMonthlyInvoices()
    {
        $id = Auth::id();
        $cashier = Cashier::where('id', $id)->first();
        $cashier_ids = Cashier::where('location_id', $cashier->location_id)->pluck('id')->toArray();
        for ($i = 1; $i <= 12; $i++) {
            $data[] = $this->whereIn('cashier_id', $cashier_ids)->whereMonth('created_at', $i)->count();
        }
        return $data;
        // $cashier_ids = Cashier::where('location_id', $location_id)->pluck('id')->toArray();
        // for ($i = 1; $i <= 12; $i++) {
        //     $data[] = $this->whereIn('cashier_id', $cashier_ids)->whereMonth('created_at', $i)->count();
        // }
        // return $data;
    }
}
