<?php

namespace App\Models;

use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
/*
 * Invoice
 * php version 8
 *
 * @category Model

 * */

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    const PAY_STATUS = [
        'NONE' => 1,
        'PARTIAL' => 2,
        'DONE' => 3,
    ];

    const STATUS = [
        'PENDING' => 0,
        'CONFIRMED' => 1,
    ];

    protected $fillable = [
        'customer_id',
        'customer_name',
        'customer_address',
        'customer_email',
        'customer_mobile',
        'customer_company',
        'quotation_id',
        'code',
        'template_id',
        'date',
        'due_date',
        'remark',
        'ref_no',
        'sub_total',
        'discount',
        'discount_type',
        'discount_value',
        'other_discount',
        'total',
        'attention_name',
        'attention_address',
        'is_scheduled',
        'schedule_count',
        'schedule_date',
        'schedule_type',
        'status',
        'pay_status',
        'paid_amount',
        'due_amount',
        'temp_due_amount',
        'temp_paid_amount',
        'total_discount',
        'invoice_parameters',
        'outstanding_status',
        'url_key',
        'url_first_view_at',
        'url_last_view_at',
        'url_view_count',
        'refund_amount',
        'temp_refund_amount',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'total_receipt',
        'invoice_receipt',
        'total_refund',
        'new_total_receipt',
        'total_due',
        'payment_status',
        'restore_total',
        'restore_paid',
        'total_days',
        'cash_sales',
        'temp_due_amount_formatted',
        'temp_paid_amount_formatted',
        'paid_amount_formatted',
        'other_discount_formatted',
        'discount_formatted',
    ];

    protected $casts = [
        'paid_amount' => 'float',
        'due_amount' => 'float',
        'temp_due_amount' => 'float',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id')->orderBy('position', 'asc');
    }

    public function restore_items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id', 'id')->withTrashed();
    }


    public function costs()
    {
        return $this->hasMany(InvoiceCost::class, 'invoice_id', 'id');
    }

    public function email()
    {
        return $this->hasOne(InvoiceMail::class, 'invoice_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id', 'id');
    }
    public function income()
    {
        return $this->hasMany(Income::class, 'invoice_id', 'id');
    }

    public function taxes()
    {
        return $this->hasMany(InvoiceItemTax::class, 'invoice_id', 'id');
    }
    public function parameters()
    {
        return $this->hasMany(InvoiceItemParameter::class, 'invoice_id', 'id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class, 'customer_id', 'id');
    }
    public function transaction()
    {
        return $this->hasMany(TransactionLog::class, 'invoice_id', 'id');
    }

    public function receipt()
    {
        return $this->hasMany(InvoiceReceipt::class, 'invoice_id', 'id');
    }

    public function refund()
    {
        return $this->hasMany(ReceiptRefund::class, 'invoice_id', 'id');
    }

    public function receiptConfirm()
    {
        return $this->hasMany(InvoiceReceipt::class, 'invoice_id', 'id')->where('confirm_status',1);
    }

    public function refundConfirm()
    {
        return $this->hasMany(ReceiptRefund::class, 'invoice_id', 'id')->where('confirm_status',1);
    }

    public function restore_receipt()
    {
        return $this->hasMany(InvoiceReceipt::class, 'invoice_id', 'id')->withTrashed();
    }

    public function getInTotalAttribute()
    {
        return $this->in_sub_total - $this->in_discount;
    }

    public function getInSubTotalAttribute()
    {
        $invoice_discount = $this->discount;
        $discount = $this->items->sum('discount') + number_format((float)$invoice_discount, 2, '.', '');
        $total = $this->items->sum('total');
        $total_tax = 0;
        foreach ($this->taxes as $tax) {
            $rate = $tax->rate;
            $total_tax += ($total - $discount) * $rate / 100;
        }
        return number_format((float)($total - $discount) + $total_tax, 2, '.', '');
    }

    public function getInDiscountAttribute()
    {
        $discount = $this->items->sum('discount');
        return $discount;
    }
    public function getTotalDiscountAttribute()
    {
        $discount = $this->discount;
        return $discount;
    }

    public function getCostAmountAttribute()
    {
        return $this->costs->sum('amount');
    }
    public function getPaidAmountAttribute()
    {
        return $this->payments->sum('paid_amount');
    }

    public function getTotalReceiptAttribute()
    {
        $paid_amount = $this->receipt->where('confirm_status',1)->sum('paid_amount');
        return number_format((float)$paid_amount, 2, '.', '');
    }

    public function getInvoiceReceiptAttribute()
    {
        $paid_amount = $this->receipt->sum('paid_amount');
        return number_format((float)$paid_amount, 2, '.', '');
    }

    public function getTotalRefundAttribute()
    {
        $refund_amount = $this->refund->where('confirm_status',1)->sum('refund_amount');
        return number_format((float)$refund_amount, 2, '.', '');
    }

    public function getNewTotalReceiptAttribute()
    {
        $paid_amount = $this->receipt->where('confirm_status',1)->sum('paid_amount');
        $refund_amount = $this->refund->where('confirm_status',1)->sum('refund_amount');
        $new_total = $paid_amount - $refund_amount;
        return number_format((float)$new_total, 2, '.', '');
    }

    public function getTotalDueAttribute()
    {
        $total = $this->total;
        $paid_amount = $this->receipt->where('confirm_status',1)->sum('paid_amount');
        // $refund_amount = $this->refund->where('confirm_status',1)->sum('refund_amount');
        $due = $total - $paid_amount ;
        return number_format((float)$due, 2, '.', '');
    }

    public function getTotalCreditAttribute()
    {
        $credit = $this->total_receipt - $this->in_total;
        return number_format((float)$credit, 2, '.', '');
    }


    public function getPaymentStatusAttribute()
    {
        return $this->receipt->where('tenant_id', Auth::user()->tenant_id)->count();
    }

    public function getRestoreTotalAttribute()
    {
        //$items=$this->items->withTrashed()->get();
        return $this->items->sum('total');
       // return $this->restore_items->sum('total');
        //return $items->sum('total');
    }

    public function getRestorePaidAttribute()
    {
        return $this->receipt->sum('paid_amount');
        //return $this->restore_receipt->sum('paid_amount');
    }


    public function getTotalDaysAttribute()
    {
        $date = $this->due_date;
        $diff = now()->diffInDays(Carbon::parse($date));
        return $diff;
    }
    public function getCashSalesAttribute()
    {
        $cash = $this->receipt->where('status', 0)->where('pay_method', 3)->sum('paid_amount');

        return $cash;
    }

    public function Intotal()
    {
        //$items=$this->items->withTrashed()->get();
        $invoice_discount = $this->discount;
        $discount = $this->items->sum('discount') + number_format((float)$invoice_discount, 2, '.', '');
        $total = $this->items->sum('total');
        $total_taxt = 0;
        foreach ($this->taxes as $taxt) {

            $rate = $taxt->rate;
            $total_taxt += ($total - $discount) * $rate / 100;
        }
        //number_format((double)($total-$discount) + $total_taxt, 2, '.', '');
        $in_total = ($total - $discount) + $total_taxt;
        return $in_total;
        //return $items->sum('total');
    }

    public function search($query)
    {
        $payload = $this->where('tenant_id', Auth::user()->tenant_id);

        $payload = $payload->where(function ($payload) use ($query) {
            $payload = $payload->where('code', 'like', '%' . $query . '%')
            ->orWhere('customer_name', 'like', '%' . $query . '%')
            ->orWhere('customer_company', 'like', '%' . $query . '%')
            ->orWhere('pay_status', 'like', '%' . $query . '%');
        });

        return $payload->limit(10)->get();
    }

    public function getSalesChartData()
    {
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 1)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 2)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 3)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 4)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 5)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 6)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 7)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 8)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 9)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 10)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 11)->sum('total');
        $data[] = $this->where('tenant_id',Auth::user()->tenant_id)->where('status',1)->whereYear('date', Carbon::today())->whereMonth('date', 12)->sum('total');

        return $data;
    }

    public function DueInvoice($user_id)
    {
        return $this->whereDate('due_date', Carbon::today())->where('pay_status', '!=', 3)->where('tenant_id', $user_id)->get();
    }

    public function getTempDueAmountFormattedAttribute()
    {
        return number_format((float)$this->temp_due_amount, 2, '.', '');
    }

    public function getTempPaidAmountFormattedAttribute()
    {
        return number_format((float)$this->temp_paid_amount, 2, '.', '');
    }

    public function getPaidAmountFormattedAttribute()
    {
        return number_format((float)$this->paid_amount, 2, '.', '');
    }

    public function getOtherDiscountFormattedAttribute()
    {
        return number_format(floatval($this->other_discount), 2);
    }

    public function getDiscountFormattedAttribute()
    {
        return number_format(floatval($this->discount), 2);
    }

}
