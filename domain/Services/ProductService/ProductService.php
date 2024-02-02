<?php

namespace domain\Services\ProductService;

use App\Models\PosOrderItem;
use App\Models\Product;

use App\Models\ProductCost;
use App\Models\Stock;
use App\Models\StockLog;
use Carbon\Carbon;
use domain\Facades\StockLogFacade\StockLogFacade;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    protected $product;
    protected $cost;
    protected $order_item;
    protected $stock;
    protected $stock_log;
    public function __construct()
    {
        $this->product = new Product();
        $this->cost = new ProductCost();
        $this->order_item = new PosOrderItem();
        $this->stock = new Stock();
        $this->stock_log = new StockLog();
    }


    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store(array $data)
    {
        $data['created_by'] = Auth::user()->id;

        if (!array_key_exists('product_category_id', $data)) {
            $data['product_category_id'] = 1;
        }

        $count = $this->product->count();

        $code = 'P' . sprintf('%05d', $count + 1);
        $check = $this->product->where('code', $code)->first();

        while ($check) {
            $count++;
            $code = 'P' . sprintf('%05d',  $count);
            $check = $this->product->where('code', $code)->first();
        }

        $data['code'] = $code;

        $product = $this->product->where('name', $data['name'])->first();
        if (!$product) {

            $product_data = $this->product->create($data);

            $today = Carbon::now();

            $log_data['product_id'] = $product_data->id;
            $log_data['quantity'] = $product_data->stock_quantity;
            $log_data['reason'] = 'Added as a new product';
            $log_data['created_by'] = Auth::id();
            $log_data['remarks'] = 'Added as a new product';
            $log_data['transaction_type_id'] = 1;
            $log_data['date'] = $today->toDateString();
            StockLogFacade::store($log_data);
        } else {
            return "This product already exists";
        }
    }

    public function getNewCode()
    {
        $count = Product::where('status', 0)->withTrashed()->count();
        //Uniqu product code generator
        $code = sprintf('%05d',  $count + 1);
        $check = Product::withTrashed()->where('code', $code)->first();
        while ($check) {
            $count++;
            $code = sprintf('%05d',  $count);
            $check = Product::withTrashed()->where('code', $code)->first();
        }

        return $code;
    }

    public function getWithDetails($id)
    {
        return $this->product->findOrFail($id);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return void
     */
    public function show($id)
    {
        return $this->product->findOrFail($id)->load('costs');
    }

    public function get($id)
    {
        return $this->product->findOrFail($id);
    }

    public function getFirst()
    {
        return $this->product->get();
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return void
     */

    public function update($id, $data)
    {
        $data['updated_by'] = Auth::user()->id;
        if (!array_key_exists('product_category_id', $data)) {
            $data['product_category_id'] = 1;
        }
        $product = $this->product->findOrFail($id);
        $product->update($data);
    }

    public function stockUpdate($id, $data)
    {
        $data['updated_by'] = Auth::user()->id;
        $product = $this->product->findOrFail($id);
        $today = \Carbon\Carbon::now();

        $data['product_id'] = $id;
        $data['created_by'] = Auth::id();
        $data['cost'] = $product->cost;
        $data['date'] = $today->toDateString();
        StockLogFacade::store($data);

        if ($data['transaction_type_id'] == 1) {
            $productData['stock_quantity'] = $product->stock_quantity + $data['quantity'];
        } else {
            $productData['stock_quantity'] = $product->stock_quantity - $data['quantity'];
        }
        $product->update($productData);
    }

    /**
     * Delete
     * delete specific data using pos_customer_id
     *
     * @param  int   $pos_customer_id
     * @return void
     */
    public function delete(int $product_id, int $order_id)
    {
        $this->order_item->where('product_id', $product_id)->where('order_id', $order_id)->delete();
        return $this->product->find($product_id)->delete();
    }

    public function addCost($id, $data)
    {
        $product = $this->product->findOrFail($id);

        $product->costs()->create([
            'expense_sub_category_id' => $data['expense_sub_category_id'],
            'expense_category_id' => $data['expense_category_id'],
            'supplier_id' => $data['supplier_id'],
            'amount' => $data['amount'],
            'quantity' => $data['quantity'],
            'remark' => $data['remark'],
        ]);
    }

    public function updateCost($id, $data)
    {

        $cost = $this->cost->findOrFail($id);
        $cost->update($data);
    }

    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $product = $this->product->findOrFail($id);
        $product->costs()->delete();
        return $product->delete();
    }

    public function deleteCost($id)
    {
        $cost = $this->cost->findOrFail($id);
        return $cost->delete();
    }

    public function getCost($id)
    {
        return $this->cost->findOrFail($id);
    }

    /**
     * status
     *
     * @param  mixed $id
     * @return void
     */
    public function status($id)
    {
        $product = $this->product->findOrFail($id);
        if ($product->status == 0) {
            $product->status = 1;
        } else {
            $product->status = 0;
        }
        $product->update();
        return $product;
    }

    public function search($data)
    {
        return  $this->product->search($data);
    }

    public function restoreProduct($id)
    {
        return $this->product->onlyTrashed()->where('id', $id)->restore();
    }

    public function permanentDelete($id)
    {
        $product = $this->product->withTrashed()->findOrFail($id);
        return $product->forceDelete();
    }
    public function getLatestProduct()
    {
        $count = $this->product->count();
        if ($count > 0) {
            $product = $this->product->latest('id')->first(['id', 'name', 'selling', 'introduction']);
            return $product;
        } else {
        }
    }

    public function all()
    {
        return $this->product->get();
    }

    public function searchByCategory($category_id)
    {
        return $this->product->where('product_category_id', $category_id)->get();
    }

    public function finishGoodByNameBarcode(string $name, int $product_category_id)
    {
        return $this->product->getFinishGoodByNameBarcode($name, $product_category_id);
    }

    public function getById($product_id)
    {
        $product = $this->product->getById($product_id);
        return $product;
    }
}
