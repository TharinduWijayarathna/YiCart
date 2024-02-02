<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillPayment extends Model
{
    use HasFactory;

    const STATUS = [
        'CREDIT_BILL' => 0,
        'DONE' => 1,
    ];

    protected $fillable = [
        'created_by',
        'customer_id',
        'code',
        'order_id',
        'order_total',
        'paid_amount',
        'balance',
        'remark',
        'date',
        'status',
        'change',
        'accepted_amount',
    ];

    protected $appends = [
        'formatted_accepted_amount',
    ];

    public function getCode(string $code)
    {
        return $this->where('code', $code)->first();
    }

    public function getFormattedAcceptedAmountAttribute()
    {
        return number_format($this->accepted_amount, 2);
    }
}
