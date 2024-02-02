<?php

namespace App\Http\Controllers;

use domain\Facades\PosOrderFacade\PosOrderFacade;
use Inertia\Inertia;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\DataResource;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use domain\Facades\ImageFacade\ImageFacade;
use domain\Facades\ProductFacade\ProductFacade;
use App\Http\Requests\Product\UpdateStockRequest;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;

class ProductController extends ParentController
{

    public function index()
    {
        return Inertia::render('Product/index');
    }

    public function get(int $id)
    {
        return ProductFacade::get($id);
    }

    public function storeCategory()
    {
        return Inertia::render('Product/category');
    }

    public function store(CreateProductRequest $request)
    {
        if ($request->has('image')) {
            $image = ImageFacade::store($request->file('image'));
            $request->merge(['image_id' => $image->id]);
        }
        return ProductFacade::store($request->all());
    }

    public function cartAll()
    {
        return ProductFacade::all();
    }

    public function all(Request $request)
    {
        $query = Product::where('status', 0)->orderBy('created_at', 'desc');

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

    public function search(Request $request)
    {
        $payload = ProductFacade::search($request['params']['search']);
        return DataResource::collection($payload);
    }

    public function getWithDetails(int $id)
    {
        return ProductFacade::getWithDetails($id);
    }

    public function update(UpdateProductRequest $request, int $id)
    {
        try {
            if ($request->has('image')) {
                $image = ImageFacade::store($request->file('image'));
                $request->merge(['image_id' => $image->id]);
            }
            return ProductFacade::update($id, $request->all());

        } catch (\Throwable $th) {
            return response()->json([
                // 'message' => 'Product update failed'
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function stockUpdate(UpdateStockRequest $request, int $id)
    {
        try {
            ProductFacade::stockUpdate($id, $request->validated());
            return new DataResource(Product::with('costs')->findOrFail($id));
        } catch (\Throwable $th) {
            return response()->json([
                // 'message' => 'Product update failed'
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function delete($product_id)
    {
        $order = PosOrderFacade::getOrCreate();
        return ProductFacade::delete($product_id, $order->id);
    }

    public function searchByCategory(int $category_id)
    {
        return ProductFacade::searchByCategory($category_id);
    }
}
