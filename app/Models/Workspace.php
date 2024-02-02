<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workspace extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'status',
        'expired_date',
        'channel_id',
        'plan_id',
        //package
        'product',
        'invoice',
        'supplier',
        'customer',
        'receipt',
        'voucher',
        'quotation',
        'transaction',
        'stock',
        'report',
        'uom',
        'product_category',
        'invoice_parameters',
        'expenses_category',
        'business_configuration',
        'email_setting',
        'accounts',
        'tax_registry',
        'user_registry',
        'commission',
        'invoice_template',
        'plan',
        'create_date',
        'report_outstanding',
        'report_profit_and_loss',
        'report_expenses',
        'report_product_sale',
        'report_stock_movement',
    ];
}
