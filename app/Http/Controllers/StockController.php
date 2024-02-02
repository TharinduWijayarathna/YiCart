<?php

namespace App\Http\Controllers;

use App\Exports\ProductStockExport;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Resources\DataResource;
use App\Models\Product;
use domain\Facades\ProductFacade\ProductFacade;
use domain\Facades\StockFacade\StockFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\QueryBuilder\QueryBuilder;

class StockController extends ParentController
{
    public function index()
    {
        return Inertia::render('Stock/index');
    }

    public function all(Request $request)
    {
        $query = Product::where('status', 0)
                ->where('stock_quantity', '<=', 0)
                ->orderBy('created_at', 'desc');

        $payload = $query->where(function ($query) use ($request) {
            if (isset($request->search_product_code)) {
                $query->where('code', 'like', '%' . $request->search_product_code . '%');
            }
            if (isset($request->search_product_name)) {
                $query->where('name', 'like', '%' . $request->search_product_name . '%');
            }
            if (isset($request->search_product_category)) {
                $query->where('product_category_id', 'like', '%' . $request->search_product_category . '%');
            }
            if (isset($request->search_product_selling_max) && isset($request->search_product_selling_min)) {
                $min = floatval(str_replace(",", "", $request->search_product_selling_min));
                $max = floatval(str_replace(",", "", $request->search_product_selling_max));
                if ($max != 0) {
                    $query->where('selling', '>=', $min)->where('selling', '<=', $max);
                } else {
                    $query->where('selling', '>=', $min);
                }
            } else if (isset($request->search_product_selling_min)) {
                $min = floatval(str_replace(",", "", $request->search_product_selling_min));
                $query->where('selling', '>=', $min);
            } else if (isset($request->search_product_selling_max)) {
                $max = floatval(str_replace(",", "", $request->search_product_selling_max));
                if ($max != 0) {
                    $query->where('selling', '<=', $max);
                }
            }
            if (isset($request->search_product_cost_max) && isset($request->search_product_cost_min)) {
                $min = floatval(str_replace(",", "", $request->search_product_cost_min));
                $max = floatval(str_replace(",", "", $request->search_product_cost_max));
                if ($max != 0) {
                    $query->where('cost', '>=', $min)->where('cost', '<=', $max);
                } else {
                    $query->where('cost', '>=', $min);
                }
            } else if (isset($request->search_product_cost_min)) {
                $min = floatval(str_replace(",", "", $request->search_product_cost_min));
                $query->where('cost', '>=', $min);
            } else if (isset($request->search_product_cost_max)) {
                $max = floatval(str_replace(",", "", $request->search_product_cost_max));
                if ($max != 0) {
                    $query->where('cost', '<=', $max);
                }
            }
        });
        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id', 'name'])->with('unit')
            ->paginate(request('per_page', config('basic.pagination_per_page')));
        return DataResource::collection($payload);
    }

    public function get($product_id)
    {
        return ProductFacade::get($product_id);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        try {
            ProductFacade::update($id, $request->validated());
            return new DataResource(Product::with('costs')->findOrFail($id));
        } catch (\Throwable $th) {
            return response()->json([
                // 'message' => 'Product update failed'
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function stockExport(Request $request, ProductStockExport $productExport){
        $query = Product::where('status', 0)->orderBy('created_at', 'desc');

        $payload = $query->where(function ($query) use ($request) {
            if (isset($request->search_product_code)) {
                $query->where('code', 'like', '%' . $request->search_product_code . '%');
            }
            if (isset($request->search_product_name)) {
                $query->where('name', 'like', '%' . $request->search_product_name . '%');
            }
            if (isset($request->search_product_selling_max) && isset($request->search_product_selling_min)) {
                $min = floatval(str_replace(",", "", $request->search_product_selling_min));
                $max = floatval(str_replace(",", "", $request->search_product_selling_max));
                if ($max != 0) {
                    $query->where('selling', '>=', $min)->where('selling', '<=', $max);
                }else{
                    $query->where('selling', '>=', $min);
                }
            }else if (isset($request->search_product_selling_min)) {
                $min = floatval(str_replace(",", "", $request->search_product_selling_min));
                $query->where('selling', '>=', $min);
            }else if (isset($request->search_product_selling_max)) {
                $max = floatval(str_replace(",", "", $request->search_product_selling_max));
                if ($max != 0) {
                    $query->where('selling', '<=', $max);
                }
            }
            if (isset($request->search_product_cost_max) && isset($request->search_product_cost_min)) {
                $min = floatval(str_replace(",", "", $request->search_product_cost_min));
                $max = floatval(str_replace(",", "", $request->search_product_cost_max));
                if ($max != 0) {
                    $query->where('cost', '>=', $min)->where('cost', '<=', $max);
                }else{
                    $query->where('cost', '>=', $min);
                }
            }else if (isset($request->search_product_cost_min)) {
                $min = floatval(str_replace(",", "", $request->search_product_cost_min));
                $query->where('cost', '>=', $min);
            }else if (isset($request->search_product_cost_max)) {
                $max = floatval(str_replace(",", "", $request->search_product_cost_max));
                if ($max != 0) {
                    $query->where('cost', '<=', $max);
                }
            }
        })->get();

        $per_page = $request->per_page;
        $page = $request->page;

        $skip = $per_page * ($page - 1);

        // create unique name for file
        $name = 'productsReport_' . Auth::id() . time() . '.xlsx';

        Excel::store($productExport->export($payload), config('filesystems.disks.do.folder') . '/products/' . $name, 'do', \Maatwebsite\Excel\Excel::XLSX, [
            'visibility' => 'public',
        ]);

        return response()->json([
            'url' => config('filesystems.disks.do.public_url') . '/' . config('filesystems.disks.do.folder') . '/products/' . $name,
        ]);
    }

}
