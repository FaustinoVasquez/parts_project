<?php

namespace Database\Seeders;

use App\Models\SubCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubCategory::create([
            'name' => 'SubCategory 1',
            'category_id' => 1
        ]);


        SubCategory::create([
            'name' => 'SubCategory 2',
            'category_id' => 2
        ]);


        SubCategory::create([
            'name' => 'SubCategory 3',
            'category_id' => 3
        ]);
    }
}
