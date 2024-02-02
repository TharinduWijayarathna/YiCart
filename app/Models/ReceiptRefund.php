<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/*
 * ReceiptRefund
 * php version 8
 *
 * @category Model
 
 * */
class ReceiptRefund extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'invoice_code',
        'receipt_id',
        'receipt_code',
        'refund_amount',
        'remarks',
        'date',
        'status',
        'refund_status',
        'confirm_status',
    ];

    public function Receipt()
    {
        return $this->belongsTo(Receipt::class, 'receipt_id', 'id');
    }

    public function Invoice()
    {
        return $this->belongsTo(Receipt::class, 'invoice_id', 'id');
    }
}
