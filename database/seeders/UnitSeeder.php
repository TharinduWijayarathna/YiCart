<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            ["title" => "Kg"],
            ["title" => "ml"],
            ["title" => "L"],
            ["title" => "pieces"],
        ];

        foreach ($array as $data) {
            $row = Unit::where('title',$data['title'])->first();
            if (!$row) {
                Unit::create($data);
            }
        }
    }
}
