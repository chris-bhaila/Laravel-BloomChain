<?php


namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ShoeSeeder::class,
            PriceSeeder::class,
            StockSeeder::class,
            OrderSeeder::class,
            DiscountSeeder::class,  
        ]);
    }
}





//DEFAULT CODE I DONT UNDERSTAND DONT WANT TO UNDERSTAND SOMETHING TO DO WITH FACTORY

// namespace Database\Seeders;

// use App\Models\User;
// // use Illuminate\Database\Console\Seeds\WithoutModelEvents;
// use Illuminate\Database\Seeder;

// class DatabaseSeeder extends Seeder
// {
//     /**
//      * Seed the application's database.
//      */
//     public function run(): void
//     {
//         // User::factory(10)->create();

//         User::factory()->create([
//             'name' => 'Test User',
//             'email' => 'test@example.com',
//         ]);
//     }
// }
