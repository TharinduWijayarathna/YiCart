<?php

namespace App\Models;

use App\Models\Supplier;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCost extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'expense_category_id',
        'expense_sub_category_id',
        'supplier_id',
        'remark',
        'quantity',
        'amount',
    ];

    protected $appends = [
        'expense_category_title',
        'expense_sub_category_title',
        'supplier_name',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function expenseCategory()
    {
        return $this->hasOne(ExpenseCategory::class, 'id', 'expense_category_id');
    }

    public function expenseSubCategory()
    {
        return $this->hasOne(ExpenseSubCategory::class, 'id', 'expense_sub_category_id');
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    public function getExpenseCategoryTitleAttribute()
    {
        return $this->expenseCategory?$this->expenseCategory->title:'';
    }

    public function getExpenseSubCategoryTitleAttribute()
    {
        return $this->expenseSubCategory?$this->expenseSubCategory->title:'';
    }

    public function getSupplierNameAttribute()
    {
        return $this->supplier?$this->supplier->name:'';
    }


}
