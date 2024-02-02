<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CreateCategory;
use App\Http\Resources\DataResource;
use App\Models\ProductCategory;
use domain\Facades\CategoryFacade\CategoryFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;

class CategoryController extends ParentController
{
    public function all()
    {
        return CategoryFacade::all();
    }

    public function categoryAll()
    {
        $query = ProductCategory::where('name', '!=', 'Other')->orderBy('name', 'asc');

        $payload = QueryBuilder::for($query)
            ->allowedSorts(['id', 'name'])
            ->paginate(request('per_page', config('basic.pagination_per_page')));

        return DataResource::collection($payload);
    }

    public function store(CreateCategory $req)
    {
        return CategoryFacade::store($req->all());
    }

    public function get($category_id)
    {
        return CategoryFacade::get($category_id);
    }

    public function update(CreateCategory $request, int $id)
    {
        try {
            CategoryFacade::update($id, $request->validated());
        } catch (\Throwable $th) {
            return response()->json([
                // 'message' => 'Product update failed'
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function delete($category_id){
        return CategoryFacade::delete($category_id);
    }

    public function unitsAll()
    {
        return CategoryFacade::unitsAll();
    }

    public function getCategory(int $category_id)
    {
        return CategoryFacade::getCategory($category_id);
    }

    public function getUnit(int $unit_id)
    {
        return CategoryFacade::getUnit($unit_id);
    }
}
