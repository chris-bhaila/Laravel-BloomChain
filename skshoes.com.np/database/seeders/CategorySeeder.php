<?php

namespace Database\Seeders;
use App\Models\Category;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Category::create([
            'category_name' => 'Full Boots',
            'category_image' => "Full_Boots.jpg",
            'feature' => true,

        ]);

        Category::create([
            'category_name' => 'Half Boots',
            'category_image' => "Half_Boots.jpg",
            'feature' => false,

        ]);

        Category::create([
            'category_name' => 'Casual Shoes',
            'category_image' => "Casual_Shoes.jpg",
            'feature' => true,

        ]);
    }
}
