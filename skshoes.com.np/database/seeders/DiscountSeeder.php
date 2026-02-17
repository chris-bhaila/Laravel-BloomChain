<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Discount;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Discount::create([
            'discount_code'=> 'dashaioffer10',
            'percentage'=> '10',
            'maximum_use'=> '40',
            'use_count'=> '30',
            'maximum_amount'=> '500',
            'expiry_date' => '2025-10-11',
            'article_id' => null,
            'category_name'=> 'Full Boots',
            'status' => 'active',
        ]);
        Discount::create([
            'discount_code'=> 'jutta10',
            'percentage'=> '11',
            'maximum_use'=> '40',
            'use_count'=> '0',
            'maximum_amount'=> '800',
            'expiry_date' => '2025-11-13',
            'article_id' => '1001_BlackDemo1',
            'category_name'=> null,
            'status' => 'active',
        ]);
        Discount::create([
            'discount_code'=> 'sk20',
            'percentage'=> '20',
            'maximum_use'=> 50,
            'use_count'=> '5',
            'maximum_amount'=> '900',
            'expiry_date' => '2025-10-11',
            'article_id' => null,
            'category_name'=> 'Half Boots',
            'status' => 'active',
        ]);
        Discount::create([
            'discount_code'=> 'sk30',
            'percentage'=> '30',
            'maximum_use'=> '10',
            'use_count'=> '10',
            'maximum_amount'=> '900',
            'expiry_date' => '2024-10-11',
            'article_id' => null,
            'category_name'=> 'Half Boots',
            'status' => 'in-active',
        ]);
    }
}
