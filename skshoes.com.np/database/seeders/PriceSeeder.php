<?php

namespace Database\Seeders;
use App\Models\Price;
use App\Models\Shoe;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shoes = Shoe::all(); // Fetch all shoes from the database

        foreach ($shoes as $shoe) {
            // Assign a base price between 2000 and 15000
            $basePrice = rand(1, 10);

            // Create at least one price entry
            Price::create([
                'article_id' => $shoe->article_id,
                'product_grouping' => json_encode([
                    'toe' => 'Soft Toe',
                    'leather' => 'Microfiber',
                ]),
                'price' => $basePrice,
            ]);
            Price::create([
                'article_id' => $shoe->article_id,
                'product_grouping' => json_encode([
                    'toe' => 'Soft Toe',
                    'leather' => 'Pure Leather',
                ]),
                'price' => $basePrice,
            ]);
            Price::create([
                'article_id' => $shoe->article_id,
                'product_grouping' => json_encode([
                    'toe' => 'Steel Toe',
                    'leather' => 'Microfiber',
                ]),
                'price' => $basePrice + rand(1, 5), // Slightly higher price for variation
            ]);
         
            Price::create([
                'article_id' => $shoe->article_id,
                'product_grouping' => json_encode([
                    'toe' => 'Steel Toe',
                    'leather' => 'Pure Leather',
                ]),
                'price' => $basePrice + rand(500, 3000), // Slightly higher price for variation
            ]);
           
        }
    }
}