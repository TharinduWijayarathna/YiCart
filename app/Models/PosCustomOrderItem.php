<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosCustomOrderItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'description',
        'size',
        'quantity',
        'unit_price',
        'total',
        'remark',
        'product_name',
        'issue_quantity',
    ];

    protected $appends = [
        'material_code',
        'material_name',
        'format_total',
        'format_unit_price',
        'format_quantity',
    ];

    public function getFormatTotalAttribute()
    {
        return number_format($this->total, 2);
    }

    public function getFormatUnitPriceAttribute()
    {
        return number_format($this->unit_price, 2);
    }

    public function getFormatQuantityAttribute()
    {
        return number_format($this->quantity, 2);
    }

    public function material()
    {
        return $this->hasOne(Material::class, 'id', 'product_id');
    }



    public function getTotal($id)
    {
        return $this->where('order_id', $id)->sum('total');
    }

    public function getMaterialNameAttribute()
    {
        return $this->material ? $this->material->name : 'N/A';
    }

    public function getMaterialCodeAttribute()
    {
        return $this->material ? $this->material->code : 'N/A';
    }
}
