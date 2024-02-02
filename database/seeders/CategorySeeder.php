<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    protected $product_category;

    public function __construct()
    {
        $this->product_category = new ProductCategory();
    }

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $product_categories = [
            [
                'name' => 'Other',
                'remarks' => 'Default Category',
            ],
        ];

        foreach ($product_categories as $product_category) {
            $check = ProductCategory::where('name', $product_category['name'])->first();
            if (!$check) {
                ProductCategory::create($product_category);
            }
        }
    }
}
