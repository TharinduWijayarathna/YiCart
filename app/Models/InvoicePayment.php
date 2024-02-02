<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/*
 * InvoicePayment
 * php version 8
 *
 * @category Model

 * */
class InvoicePayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'invoice_id',
        'type',
        'recurring_month',
        'paid_amount',
        'pay_method',
        'remarks',
        'status',
        'cheque_no',
        'card_no',
        'bank_id',
        'bank',
        'post_date',
    ];



    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }




}
