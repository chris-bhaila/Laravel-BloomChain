<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Stock;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stock::create([
            'price_id' => '1',
            'size'=> '39',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '1',
            'size'=> '40',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '1',
            'size'=> '41',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '1',
            'size'=> '42',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '1',
            'size'=> '43',
            'stock'=> '10',
        ]);

        Stock::create([
            'price_id' => '2',
            'size'=> '35',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '2',
            'size'=> '36',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '2',
            'size'=> '37',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '2',
            'size'=> '38',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '2',
            'size'=> '39',
            'stock'=> '10',
        ]);

        Stock::create([
            'price_id' => '3',
            'size'=> '36',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '3',
            'size'=> '37',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '3',
            'size'=> '38',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '3',
            'size'=> '39',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '3',
            'size'=> '40',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '4',
            'size'=> '36',
            'stock'=> '0',
        ]);
        Stock::create([
            'price_id' => '4',
            'size'=> '37',
            'stock'=> '12',
        ]);
        Stock::create([
            'price_id' => '4',
            'size'=> '38',
            'stock'=> '2',
        ]);
        Stock::create([
            'price_id' => '4',
            'size'=> '39',
            'stock'=> '0',
        ]);
        Stock::create([
            'price_id' => '5',
            'size'=> '39',
            'stock'=> '0',
        ]);
        Stock::create([
            'price_id' => '5',
            'size'=> '40',
            'stock'=> '2',
        ]);
        Stock::create([
            'price_id' => '6',
            'size'=> '40',
            'stock'=> '2',
        ]);
        Stock::create([
            'price_id' => '6',
            'size'=> '41',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '7',
            'size'=> '40',
            'stock'=> '0',
        ]);
        Stock::create([
            'price_id' => '7',
            'size'=> '41',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '8',
            'size'=> '41',
            'stock'=> '10',
        ]);
        Stock::create([
            'price_id' => '8',
            'size'=> '42',
            'stock'=> '0',
        ]);
    }
}
