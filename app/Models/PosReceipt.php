<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosReceipt extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'reason',
        'name',
        'remark',
        'price',
    ];

    protected $appends = [
        'format_price',
    ];

    public function getFormatPriceAttribute()
    {
        return number_format($this->price, 2) ;
    }
}
