<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use Faker\Factory as Faker;
use Carbon\Carbon;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 100; $i++) {
            Order::create([
                'customer_name' => $faker->name,
                'article_id' => $faker->randomElement(['1001_BlackDemo1', '1002_RedDemo2', '1003_BlackDemo3', '1004_BlackDemo4', '1005_BlackDemo5', '1006_BlackDemo6', '1007_BlackDemo7', '1008_WhiteDemo8', '1009_GreyDemo9', '1011_BrownDemo11', '1012_BlackDemo12', '1013_RedDemo13', '1014_WhiteDemo14', '1015_BlackDemo15', '1016_GreyDemo16', '1017_BlueDemo17', '1018_BrownDemo18']),
                'shoe_name' => $faker->randomElement(['Doc Martin Boots', 'Casual Shoe 1', 'Running Shoe', 'Leather Loafers', 'Sneakers']),
                'product_grouping' => json_encode($faker->randomElement([
                    ['toe' => 'SoftToe', 'leather' => 'MicroFiber'],
                    ['toe' => 'SteelToe'],
                    ['leather' => 'Pure Leather'],
                    null
                ])),
                'size' => $faker->numberBetween(35, 43),
                'address' => $faker->city, 
                'nearest_landmark' => $faker->city,
                'phone_number' => $faker->numerify('98########'),
                'email' => $faker->safeEmail,
                'status' => $faker->randomElement(['Received', 'Delivered', 'Returned']),
                'discount_code' => $faker->optional()->randomElement(['DISCOUNT_10', 'Walk11', 'Dashain', null]),
                'discounted_price' => $faker->numberBetween(100, 1000),
                'payment_method' => $faker->randomElement(['Esewa', 'Khalti', 'Cash On Delivery']),
                'price' => $faker->numberBetween(2000, 10000),
                'created_at' => Carbon::now()->subDays(100 - $i),
                'updated_at' => Carbon::now()->subDays(100 - $i),
            ]);

        }
    }
}
