<?php

namespace domain\Services\StockService;

use App\Models\Stock;
use domain\Facades\MaterialFacade\MaterialFacade;
use App\Models\Material;
use App\Models\PosOrderItem;
use App\Models\Product;
use domain\Facades\StockLogFacade\StockLogFacade;
use Illuminate\Support\Facades\Auth;

/**
 * StockService
 *
 
 * */

class StockService
{
    protected $stock;
    protected $pos_order_item;
    protected $product;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->stock = new Stock();
        $this->pos_order_item = new PosOrderItem();
        $this->product = new Product();
    }

    /**
     * All
     * retrieve all the data from stock model
     *
     * @return void
     */
    public function all()
    {
        return $this->stock->all();
    }

    /**
     * Store
     * store data in database
     *
     * @param  array $data
     *
     * @return void
     */
    public function store(array $data)
    {
        $count = $this->stock->count();

        $code = 'S' . sprintf('%05d',  $count + 1);
        $check = $this->stock->where('barcode', $code)->first();
        while ($check) {
            $count++;
            $code = 'S' . sprintf('%05d',  $count);
            $check = $this->stock->where('barcode', $code)->first();
        }

        $data['barcode'] = $code;
        return $this->stock->create($data);
    }

    /**
     * Get
     * retrieve relevant data using stock_id
     *
     * @param  int $stock_id
     * @return void
     */
    public function get(int $stock_id)
    {
        return $this->stock->find($stock_id);
    }

    /**
     * Update
     * update existing data using stock_id
     *
     * @param  array   $data
     * @param  int     $stock_id
     *
     * @return void
     */
    public function update($item, $qc, $stock, $material)
    {
        $stock->qty = $item->quantity;
        $stock->status = $item->qc_status;
        $stock->material_id = $item->material_id;
        $stock->name = $material->name;
        $stock->barcode = $item->sku;
        $stock->uom = $material->purchase_uom;
        $stock->supplier_id = $qc->vendor_id;
        $stock->category_id = $material->category;
        $stock->warehouse_id = $qc->warehouse_id;
        $stock->location_id = $item->location_id;
        $stock->bin_id = $item->bin;
        $stock->save();
        // $stock = $this->stock->find($stock_id);
        // return $stock->update($this->edit($stock, $data));
    }

    /**
     * Edit
     * merge data which retrieved from update function as an array
     *
     * @param  Stock $stock
     * @param  array $data
     * @return void
     */
    protected function edit(Stock $stock, array $data)
    {
        return array_merge($stock->toArray(), $data);
    }

    /**
     * Delete
     * delete specific data using stock_id
     *
     * @param  int  $stock_id
     * @return void
     */
    public function delete(int $stock_id)
    {
        return $this->stock->find($stock_id)->delete();
    }

    /**
     * getStock
     *
     * @param  int $sku
     * @return void
     */
    public function getStock($barcode)
    {
        return $this->stock->where('barcode', $barcode)->first();
    }

    /**
     * getList
     *
     * @param  mixed $data
     * @return void
     */
    public function getList($data)
    {
        return $this->stock->getList($data);
    }

    /**
     * getByFilter
     *
     * @param  mixed $data
     * @return void
     */
    public function getByFilter($data)
    {
        return $this->stock->getByFilter($data);
    }

    /**
     * approveExistedQC - update Existing QC in the stock or
     * approve Reverse QC already existing in the stock
     *
     * @param  Stock $stock
     * @param  QC Item GRN$item
     *
     * @return void
     */
    public function approveExistingQC(Stock $stock)
    {
        $stock->save();
    }

    /**
     * rejectExistingQC - reject QC that already existing in the stock
     *
     * @param  Stock $stock
     * @return void
     */
    public function rejectExistingQC(Stock $stock)
    {
        $stock->delete();
    }

    /**
     * reverseExistingQC - when want to reverse QC already in the stock
     *
     * @param  mixed $stock
     * @return void
     */
    public function reverseExistingQC(Stock $stock)
    {
        $stock->status = 3;
        $stock->save();
    }

    /**
     * barcodes
     *
     * @return void
     */
    public function barcodes()
    {
        return $this->stock->getList();
    }


    public function getAllByMaterial(int $material_id)
    {
        return $this->stock->getAllByMaterial($material_id);
    }

    public function totalQtyByMaterial(int $material_id)
    {
        return $this->stock->totalQtyByMaterial($material_id);
    }

    public function getStockByMaterialId(int $material_id)
    {
        return $this->stock->getStockByMaterialId($material_id);
    }

    public function getStockByMaterialIdForCal(int $material_id)
    {
        return $this->stock->getStockByMaterialIdForCal($material_id);
    }

    public function skuForGi($barcode, int $warehouse_id)
    {
        return $this->stock->getSkuForGi($barcode, $warehouse_id);
        //return $this->stock->getMaterialForStockFromBarcode($barcode);
    }

    public function getForDataForExport($search_data)
    {
        return $this->stock->getForDataForExport($search_data);
    }


    /**
     * getByBarcode
     *
     * @param  s
     * string $barcode
     * @return void
     */
    public function getByBarcode($barcode)
    {
        return $this->stock->getByBarcode($barcode);
        //return $this->stock->getMaterialForStockFromBarcode($barcode);
    }

    public function getAllByMaterialForGi(int $material_id, int $warehouse_id)
    {
        return $this->stock->getAllByMaterialForGi($material_id, $warehouse_id);
    }

    public function productDecrease($order_id)
    {
        $today = \Carbon\Carbon::now();

        $pos_order_items = $this->pos_order_item->where('order_id', $order_id)->get();
        foreach ($pos_order_items as $item) {
            $product = $this->product->findOrFail($item->product_id);
            if ($product->product_type == 1) {
                $product->stock_quantity = $product->stock_quantity - $item->quantity;
                $product->save();

                if ($product->stock_quantity >= $item->quantity) {

                    $stock_log_data['product_id'] = $product->id;
                    $stock_log_data['quantity'] = $item->quantity;
                    $stock_log_data['cost'] = $product->cost ?? 0;
                    $stock_log_data['selling_price'] = $product->selling ?? 0;
                    $stock_log_data['reason'] = "For a customer order";
                    $stock_log_data['remarks'] = "Order Issued";
                    $stock_log_data['created_by'] = Auth::id();
                    $stock_log_data['transaction_type_id'] = 0;
                    $stock_log_data['date'] = $today->toDateString();
                    StockLogFacade::store($stock_log_data);
                } else {
                    $stock_log_data['product_id'] = $product->id;
                    $stock_log_data['quantity'] = $item->quantity;
                    $stock_log_data['cost'] = $product->cost ?? 0;
                    $stock_log_data['selling_price'] = $product->selling ?? 0;
                    $stock_log_data['reason'] = "For a customer order";
                    $stock_log_data['remarks'] = "A product that is not in stock has been billed";
                    $stock_log_data['created_by'] = Auth::id();
                    $stock_log_data['transaction_type_id'] = 0;
                    $stock_log_data['date'] = $today->toDateString();
                    StockLogFacade::store($stock_log_data);
                }
            }
        }
    }
}
