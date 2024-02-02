<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/*
 * TransactionLog
 * php version 8
 *
 * @category Model
 *
 * */
class TransactionLog extends Model
{
    use HasFactory;
    use SoftDeletes;

    const TYPE = [
        'CREDIT' => 0,
        'DEBIT' => 1,
    ];

    protected $fillable = [
        'invoice_id',
        'invoice_code',
        'voucher_id',
        'voucher_no',
        'customer_mobile',
        'title',
        'amount',
        'method',
        'date',
        'cheque_no',
        'card_no',
        'bank_account_no',
        'bank_name',
        'post_date',
        'remark',
        'type',
        'customer_account_no',
        'supplier_account_no',
        'receipt_id',
        'status',
        'balance',
        'tr_code',
        'receipt_code',
        'user_bank_id',
        'user_bank_acc',
        'customer_name',
        'supplier_id',
        'supplier_name',
        'customer_company',
        'supplier_company',
        'refund_status',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'code',
    ];
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }

    public function getCodeAttribute()
    {
        $this->transaction=new TransactionLog();

        return $this->invoice?$this->invoice->code:'';
    }
}
