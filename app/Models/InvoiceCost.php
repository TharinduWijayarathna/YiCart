<?php

namespace App\Models;

use App\Models\ExpenseCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/*
 * InvoiceCost
 * php version 8
 *

 * */
class InvoiceCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'supplier_id',
        'expense_category_id',
        'date',
        'amount',
        'remark',
    ];

    protected $appends = [
        'supplier_name',
        'expense_category_name',
    ];

    public function getSupplierNameAttribute()
    {
        return $this->supplier?$this->supplier->name:'';
    }

    public function getExpenseCategoryNameAttribute()
    {
        return $this->expenseCategory?$this->expenseCategory->title:'';
    }

    public function expenseCategory()
    {
        return $this->hasOne(ExpenseCategory::class, 'id', 'expense_category_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }
}
