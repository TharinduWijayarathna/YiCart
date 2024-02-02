<?php

namespace App\Models;

use domain\Facades\TaxFacade\TaxFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class PosOrder extends Model
{
    use HasFactory;
    use SoftDeletes;

    const STATUS = [
        'PENDING' => 0,
        'DONE' => 1,
        'HOLD' => 2,
        'CANCEL' => 3,
        'RETURN' => 4,
    ];

    const DISCOUNT_TYPE = [
        'AMOUNT' => 0,
        'PERCENTAGE' => 1,
    ];

    const IS_RETURN = [
        'NO' => 0,
        'YES' => 1,
    ];

    const CREDIT_STATUS = [
        'CREDIT' => 0,
        'PAID_UP' => 1,
    ];

    protected $fillable = [
        'created_by',
        'customer_type',
        'customer_id',
        'code',
        'status',
        'sub_total',
        'total',
        'discount',
        'discount_type',
        'sales_person_id',
        'customer_paid',
        'balance',
        'is_return',
        'remark',
        'discount_remark',
        'credit_status',
        'payment_type',
        'total_tax',
    ];

    protected $appends = [
        'order_items',
        'item_sub_total',
        'customer_name',
        'cashier_name',
        'date',
        'formatted_sub_total',
        'formatted_total',
        'formatted_discount',
        'formatted_customer_paid',
        'formatted_credit',
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    public function getCustomerNameAttribute()
    {
        return $this->customer ? $this->customer->name : 'N/A';
    }

    public function cashier()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function getCashierNameAttribute()
    {
        return $this->cashier ? $this->cashier->name : 'N/A';
    }

    public function getCode(string $code)
    {
        return $this->where('code', $code)->first();
    }

    public function getActiveOrder()
    {
        return $this->where('created_by', Auth::id())->where('status', 0)->where('is_return', 0)->first();
    }

    public function getReturnOrder()
    {
        return $this->where('created_by', Auth::id())->where('status', 0)->where('is_return', 1)->first();
    }

    /**
     * items
     * get item details by id
     *
     * @return void
     */
    public function items()
    {
        return $this->hasMany(PosOrderItem::class, 'order_id', 'id');
    }

    /**
     * getItemTotalAttribute
     * get current item total
     *
     * @return void
     */
    public function getItemSubTotalAttribute()
    {
        $total = number_format($this->items->sum('sub_total'), 2);
        return $total;
    }

    /**
     * getOrderItemsAttribute
     * get order items details
     *
     * @return void
     */
    public function getOrderItemsAttribute()
    {
        return $this->items;
    }

    /**
     * customerTypeData
     * get customer type details by slug
     *
     * @return void
     */
    // public function customerTypeData()
    // {
    //     return $this->hasOne(CustomerType::class, 'slug', 'customer_type');
    // }

    /**
     * getCustomerTypeNameAttribute
     * get customer type name regarding current customer type
     *
     * @return void
     */
    public function getCustomerTypeNameAttribute()
    {
        return $this->customerTypeData ? $this->customerTypeData->name : 'N/A';
    }

    public function updateTotals($order_id, $subTotal)
    {
        $order = $this->where('id', $order_id)->first();
        if ($order) {
            $order->sub_total = $subTotal;
            $order->save();
            TaxFacade::refreshOrders($order_id);
            $order1 = $this->where('id', $order_id)->first();
            $order1->total = $order1->sub_total - $order1->discount + $order1->total_tax;
            $order1->save();
        }
        return $order1;
    }

    public function getDateAttribute()
    {
        $createdAt = $this->updated_at;
        $carbon = \Carbon\Carbon::parse($createdAt);
        $date = $carbon->toDateTimeString();
        return $this->created_at ? $date : '-';
    }

    public function getFormattedSubTotalAttribute()
    {
        return number_format($this->sub_total, 2);
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2);
    }

    public function getFormattedDiscountAttribute()
    {
        return number_format($this->discount, 2);
    }

    public function getFormattedCustomerPaidAttribute()
    {
        return number_format($this->customer_paid, 2);
    }
    public function getFormattedCreditAttribute()
    {
        return number_format($this->balance, 2);
    }
}
