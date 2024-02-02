<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosOrderTax extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        "order_id",
        "tax_id",
        "tax_amount",
        "rate",
    ];

    protected $appends = [
        'tax_name', //tax name
    ];

    public function tax()
    {
        return $this->hasOne(Tax::class, 'id', 'tax_id');
    }

    public function getTaxNameAttribute()
    {
        return $this->tax ? $this->tax->name : 'N/A';
    }
}
