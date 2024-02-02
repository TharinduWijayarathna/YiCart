<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receipt extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'receipt_no',
        'amount',
        'date',
        'status',
        'pay_method',
        'account_no',
        'bank_name',
        'bank_branch',
        'post_date',
        'ref_num',
        'cheque_num',
        'bank_id',
        'remarks',
        'customer_id',
        'customer_name',
        'customer_address',
        'customer_email',
        'customer_mobile',
        'customer_company',
        'type',
        'user_bank_acc',
        'user_bank_id',
        'refund_status',
        'refund_customer_id',
        'refund_customer_name',
        'refund_company_name',
        'refund_date',
        'refund_remarks',
        'refund_type',
        'refund_user_bank_id',
        'refund_user_bank_acc',
        'refund_invoice_status',
        'refund_confirm_status',
        'created_by',
        'updated_by',

    ];
    const STATUS = [
        'DONE' => 1,
        'PENDING' => 0,
    ];
    protected $appends = [
        'paid_amount',
        'refund_amount',
        'trash_paid_amount',
        'cash_sales',
    ];

    public function receipt_inv()
    {
        return $this->hasMany(InvoiceReceipt::class, 'receipt_id', 'id');
    }

    public function refund()
    {
        return $this->hasMany(ReceiptRefund::class, 'receipt_id', 'id');
    }


    public function receipt_inv_trash()
    {
        return $this->hasMany(InvoiceReceipt::class, 'receipt_id', 'id')->withTrashed();
    }

    public function getPaidAmountAttribute()
    {
        return $this->receipt_inv->sum('paid_amount');
    }

    public function getRefundAmountAttribute()
    {
        return $this->refund->sum('refund_amount');
    }

    public function getTrashPaidAmountAttribute()
    {
        return $this->receipt_inv->sum('paid_amount');
    }
    public function getCashSalesAttribute()
    {
        $receipt_cash = Receipt::where('status', 1)->where('type', 3)->get();
        $cash_total = 0;
        foreach ($receipt_cash as $receipts) {
            $cash_total += InvoiceReceipt::where('receipt_id', $receipts['id'])->sum('paid_amount');
        }
        return $cash_total;
    }
}
