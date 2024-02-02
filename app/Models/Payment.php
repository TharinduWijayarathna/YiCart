<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'date',
        'invoice_id',
        'receipt_id',
        'bank_id',
        'paid_amount',
        'invoice_id',
        'type',
        'recurring_month',
        'paid_amount',
        'pay_method',
        'remarks',
        'status',
        'cheque_card_no',
        'bank',
        'post_date',
    ];

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }

    public function invoice_payment()
    {
        return $this->hasMany(InvoicePayment::class, 'invoice_id', 'invoice_id');
    }
    public function receipt()
    {
        return $this->hasOne(Receipt::class, 'id', 'receipt_id');
    }

    public function bank()
    {
        return $this->hasOne(BankAccount::class, 'id', 'bank_id');
    }

    public function getPaymentsChartData()
    {
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 1)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 2)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 3)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 4)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 5)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 6)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 7)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 8)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 9)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 10)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 11)->sum('amount');
        $data[] = $this->whereYear('created_at', Carbon::today())->whereMonth('created_at', 12)->sum('amount');

        return $data;
    }
}
