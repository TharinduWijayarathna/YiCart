<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
/*
 * InvoiceItemParameter
 * php version 8
 *
 
 * */

class InvoiceItemParameter extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'tenant_id',
        'parameter_id',
        'invoice_id',
        'name',
        'description',

    ];
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'invoice_id', 'id');
    }

    public function findParameter($parameter_id, $invoice_id)
    {
        return $this->where('tax_id', $parameter_id)->where('invoice_id', $invoice_id)->first();
    }

    public function findParameters($invoice_id)
    {
        return $this->where('invoice_id', $invoice_id)->get();
    }
}
