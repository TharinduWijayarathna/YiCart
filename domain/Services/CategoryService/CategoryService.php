<?php

namespace domain\Services\CategoryService;

use App\Models\ProductCategory;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    protected $product_category;
    protected $unit;
    public function __construct()
    {
        $this->product_category = new ProductCategory();
        $this->unit = new Unit();
    }

    public function all()
    {
        return $this->product_category->where('name', '!=', 'Other')->get();
    }

    public function store(array $data)
    {
        $data['created_by'] = Auth::user()->id;

        $product_category = $this->product_category->where('name', $data['name'])->first();
        if (!$product_category) {

            $this->product_category->create($data);
        }else{
            return "This category already exists";
        }
    }

    public function get($id)
    {
        return $this->product_category->findOrFail($id);
    }

    public function getCategory($category_id)
    {
        return $this->product_category->where('id', $category_id)->first();
    }

    public function update($id, $data)
    {
        $data['updated_by'] = Auth::user()->id;

        $category = $this->product_category->findOrFail($id);

            $category->update($data);
    }

    public function delete(int $product_id)
    {
        return $this->product_category->find($product_id)->delete();
    }

    public function unitsAll()
    {
        return $this->unit->get();
    }

    public function getUnit($unit_id)
    {
        return $this->unit->where('id', $unit_id)->first();
    }
}
