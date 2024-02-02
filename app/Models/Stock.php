<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use domain\Facades\CashierManagementFacade\CashierManagementFacade;
use Carbon\Carbon;

class Stock extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'material_id',
        'name',
        'barcode',
        'uom',
        'supplier_id',
        'category_id',
        'warehouse_id',
        'location_id',
        'bin_id',
        'qty',
        'status',

        'sku', // Created barcode in the GRN
    ];

    protected $appends = [
        'material_name',
        'material_code',
        'warehouse_name',
        'location_name',
        'bin_name',
        'supplier_name',
        'category_name',
        'uom_name',
        'barcode_with_qty',
        'format_qty',
        'material_selling_price',
        // 'can_stock_remove',

        'age', // Age since created_date of that SKU
    ];

    public function material()
    {
        return $this->hasOne(Material::class, 'id', 'material_id');
    }
    public function getMaterialNameAttribute()
    {
        return $this->material ? $this->material->name : 'N/A';
    }
    public function getMaterialCodeAttribute()
    {
        return $this->material ? $this->material->code : 'N/A';
    }
    public function warehouse()
    {
        return $this->hasOne(Warehouses::class, 'id', 'warehouse_id');
    }
    public function getWarehouseNameAttribute()
    {
        return $this->warehouse ? $this->warehouse->name : 'N/A';
    }
    public function location()
    {
        return $this->hasOne(Locations::class, 'id', 'location_id');
    }
    public function getLocationNameAttribute()
    {
        return $this->location ? $this->location->name : 'N/A';
    }
    public function bin()
    {
        return $this->hasOne(Bins::class, 'id', 'bin_id');
    }
    public function getBinNameAttribute()
    {
        return $this->bin ? $this->bin->name : 'N/A';
    }
    public function supplier()
    {
        return $this->hasOne(Suppliers::class, 'id', 'supplier_id');
    }
    public function getSupplierNameAttribute()
    {
        return $this->supplier ? $this->supplier->name : 'N/A';
    }
    public function category()
    {
        return $this->hasOne(MaterialCategory::class, 'id', 'category_id');
    }
    public function getCategoryNameAttribute()
    {
        return $this->category ? $this->category->full_name : 'N/A';
    }
    public function uomData()
    {
        return $this->hasOne(UnitOfMeasure::class, 'id', 'uom');
    }
    public function getUomNameAttribute()
    {
        return $this->uomData ? $this->uomData->name : 'N/A';
    }

    public function getList()
    {
        return $this->get()->toArray();
    }

    public function getBarcodeWithQtyAttribute()
    {
        return $this->barcode . ' - ' . $this->qty;
    }

    public function getAllByMaterial(int $material_id)
    {
        return $this->where('material_id', $material_id)->where('qty', '>', 0)->get();
    }

    public function totalQtyByMaterial(int $material_id)
    {
        return $this->where('material_id', $material_id)->sum("qty");
    }

    public function getCanStockRemoveAttribute()
    {
        // return $this->whereHas('bin', function (Builder $query) {
        //     $query->where('stock_remove', 1)->where('stock_putaway', 1);
        // })->get();
        return $this->bin ? $this->bin->stock_remove : 'N/A';
    }

    public function canStockRemove()
    {
        return  $this->whereHas('bin', function ($query) {
            $query->where('stock_remove', 1)->orWhere('stock_putaway', 1);
        });
    }

    public function getStockRemoveStock($bin_id)
    {
        return $this->where('bin_id', $bin_id)->get();
    }

    public function getStockByMaterialId($material_id)
    {
        $cashier = Auth::user();
        return $this->where('material_id', $material_id)->where('location_id', $cashier->location_id)->where('qty', '>', 0)->first();
    }

    public function getStockByMaterialIdForCal($material_id)
    {
        $cashier = Auth::user();
        return $this->where('material_id', $material_id)->where('location_id', $cashier->location_id)->first();
    }

    public function getFormatQtyAttribute()
    {
        return number_format($this->qty, 2);
    }

    public function searchBarcode($search, int $warehouse_id)
    {
        return $this->where('barcode',$search )
        ->where('warehouse_id', $warehouse_id)
            ->first();
    }
    public function getSkuForGi($search, int $warehouse_id)
    {
        return $this->where('barcode', 'like', '%' . $search . '%')
        ->where('warehouse_id', $warehouse_id)
            ->limit(10)
            ->get();
    }

    /**
     * getByBarcode
     *
     * @param  string $barcode
     * @return void
     */
    public function getByBarcode($barcode)
    {
        return $this->where('barcode',$barcode)->first();
    }

    public function getMaterialSellingPriceAttribute()
    {
        return $this->material ? $this->material->selling_price : 'N/A';
    }

    /**
     * getAllByMaterialForGi
     *
     * @param  int $material_id
     * @param  int $warehouse_id
     * @return void
     */
    public function getAllByMaterialForGi(int $material_id, int $warehouse_id)
    {
        return $this->where('material_id', $material_id)->where('warehouse_id', $warehouse_id)->where('qty', '>',0)->get();
    }

    public function getForDataForExport($search_data)
    {
        $query = $this->query();
        if ($search_data->material)
        {
            $query = $query->where('material_id', $search_data->material);
        }
        if ($search_data->warehouse)
        {
            $query = $query->where('warehouse_id', $search_data->warehouse);
        }
        if ($search_data->location)
        {
            $query = $query->where('location_id', $search_data->location);
        }
        if ($search_data->bin)
        {
            $query = $query->where('bin_id', $search_data->bin);
        }
        if ($search_data->search_barcode)
        {
            $code = $search_data->search_barcode;
            $query = $query->WhereHas('material', function ($query) use ($code) {
                $query->where('barcode',$code);
            });
        }
        if ($search_data->category)
        {
            $cat_id = $search_data->category;
            $query = $query->WhereHas('material', function ($query) use ($cat_id) {
                $query->where('category_l1_id', $cat_id)->orWhere('category_l2_id', $cat_id)->orWhere('category_l3_id', $cat_id)->orWhere('category_l4_id', $cat_id);
            });
        }
        // dd($query[261]);
        return $query->get();
    }

    /**
     * getAgeAttribute
     *
     * @return void
     */
    public function getAgeAttribute()
    {
        $createdAt = Carbon::parse($this->created_at);
        $now = Carbon::now();

        $years = $createdAt->diffInYears($now);
        $months = $createdAt->addYears($years)->diffInMonths($now);
        $days = $createdAt->addMonths($months)->diffInDays($now);

        return $years . ' years, ' . $months . ' months, ' . $days . ' days';
    }
}
