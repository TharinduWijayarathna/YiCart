<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosOrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    const TYPE = [
        'PRODUCT'=>0,
        'VOUCHER'=>1,
    ];

    const RETURN_STATUS = [
        'order'=>0,
        'return'=>1,
    ];

    protected $fillable = [
        'order_id',
        'product_id', // Finish Good Id - Material Id
        'unit_price',
        'quantity',
        'sub_total',
        'total',
        'discount',
        'discount_type',
        'type',
        'voucher_id',
        'return_status',
        'return_quantity',
        'discount_remark',
    ];

    protected $appends = [
        'image_url',
        'product_name',
        'product_code',
        'available_qty',
        'formatted_sub_total',
        'formatted_total',
    ];

    public function getImageUrlAttribute()
    {
        return $this->product ? $this->product->image_url : null;
    }

    public function fgData()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function getProductNameAttribute()
    {
        return $this->product ? $this->product->name : 'N/A';
    }
    public function getProductCodeAttribute()
    {
        return $this->product ? $this->product->code : 'N/A';
    }


    public function voucherData()
    {
        return $this->hasOne(GiftVoucherItem::class, 'id', 'voucher_id');
    }

    /**
     * getFgNameAttribute
     * Get current finish good name
     *
     * @return void
     */
    // public function getFgNameAttribute()
    // {
    //     if($this->type == 1){
    //         return 'Voucher-'.sprintf($this->voucherData->amount);
    //     }
    // }

    /**
     * getFgCodeAttribute
     * Get current finish good code
     *
     * @return void
     */
    public function getFgCodeAttribute()
    {
        if($this->type == 1){
            return $this->voucherData ? $this->voucherData->voucher_code : 'N/A';
        }else{
            return $this->fgData ? $this->fgData->code : 'N/A';
        }
    }

    /**
     * getAll
     * Get all order items according to the given id
     *
     * @param  int  $order_id
     * @return void
     */
    public function getAll(int $order_id)
    {
        return $this->where('order_id', $order_id)->get();
    }

    /**
     * total
     * Get all order items total sum according to the given id
     *
     * @param  int $order_id
     * @return void
     */
    public function subTotal(int $order_id)
    {
        return $this->where('order_id', $order_id)->get()->sum('sub_total');
    }

    public function getReturnItem(int $order_id)
    {
        return $this->where('order_id', $order_id)->where('return_status', 1)->get();
    }

    public function getWithoutReturnItems(int $order_id)
    {
        return $this->where('order_id', $order_id)->where('return_status', 0)->get();
    }

    public function getAvailableQtyAttribute()
    {
        return $this->quantity ? $this->quantity - $this->return_quantity : 'N/A';
    }

    public function getFormattedSubTotalAttribute()
    {
        return number_format($this->sub_total, 2);
    }

    public function getFormattedTotalAttribute()
    {
        return number_format($this->total, 2);
    }
}
