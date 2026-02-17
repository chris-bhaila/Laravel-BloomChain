<?php

namespace Database\Seeders;
use App\Models\Shoe;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shoes = [
            ['1001_BlackDemo1', 'Doc Martin Boot', 'Black', 'Full Boots'],
            ['1002_RedDemo2', 'Doc Martin Boot', 'Red', 'Full Boots'],
            ['1003_BlackDemo3', 'Casual Shoe 1', 'Black', 'Casual Shoes'],
            ['1004_BlackDemo4', 'Doc Martin Half Boot 4', 'Black', 'Half Boots'],
            ['1005_BlackDemo5', 'Doc Martin Half Boot3', 'Black', 'Half Boots'],
            ['1006_BlackDemo6', 'Doc Martin Half Boot', 'Black', 'Half Boots'],
            ['1007_BlackDemo7', 'Doc Martin Half Boot4', 'Black', 'Half Boots'],
            ['1008_WhiteDemo8', 'Best Boot 8', 'White', 'Half Boots'],
            ['1009_GreyDemo9', 'Best Boot 9', 'Grey', 'Casual Shoes'],
            ['1010_BlueDemo10', 'Sport Shoe 10', 'Blue', 'Casual Shoes'],
            ['1011_BrownDemo11', 'Classic Shoe 11', 'Brown', 'Full Boots'],
            ['1012_BlackDemo12', 'Stylish Boot 12', 'Black', 'Full Boots'],
            ['1013_RedDemo13', 'Stylish Boot 13', 'Red', 'Full Boots'],
            ['1014_WhiteDemo14', 'Sneaker 14', 'White', 'Casual Shoes'],
            ['1015_BlackDemo15', 'Leather Boot 15', 'Black', 'Half Boots'],
            ['1016_GreyDemo16', 'Running Shoe 16', 'Grey', 'Casual Shoes'],
            ['1017_BlueDemo17', 'Sport Shoe 17', 'Blue', 'Casual Shoes'],
            ['1018_BrownDemo18', 'Formal Shoe 18', 'Brown', 'Full Boots'],
            ['1019_BlackDemo19', 'Casual Boot 19', 'Black', 'Half Boots'],
            ['1020_WhiteDemo20', 'Trendy Shoe 20', 'White', 'Casual Shoes'],
            ['1021_GreyDemo21', 'Hiking Boot 21', 'Grey', 'Full Boots'],
            ['1022_BlueDemo22', 'Sneaker 22', 'Blue', 'Casual Shoes'],
            ['1023_BrownDemo23', 'Stylish Shoe 23', 'Brown', 'Half Boots'],
            ['1024_BlackDemo24', 'Leather Shoe 24', 'Black', 'Full Boots'],
            ['1025_RedDemo25', 'Trendy Boot 25', 'Red', 'Half Boots'],
            ['1001_BrownDemo26', 'Doc Martin Boot', 'Brown', 'Full Boots'],
            ['1001_RedDemo27', 'Doc Martin Boot', 'Red', 'Full Boots'],
        ];

        foreach ($shoes as $shoe) {
            $isSpecialShoe = in_array($shoe[0], ['1001_BlackDemo1', '1002_RedDemo2', '1003_BlackDemo3', '1004_BlackDemo4', '1005_BlackDemo5', '1026_BlackDemo26', '1027_RedDemo27']);

            Shoe::create([
                'article_id' => $shoe[0],
                'shoe_name' => $shoe[1],
                'shoe_color' => $shoe[2],
                'shoe_image1' => 'image1.jpg',
                'shoe_image2' => 'image2.jpg',
                'shoe_image3' => 'image3.jpg',
                'shoe_image4' => $isSpecialShoe ? 'image4.jpg' : null,
                'shoe_image5' => $isSpecialShoe ? 'image5.jpg' : null,
                'shoe_image6' => $isSpecialShoe ? 'image6.jpg' : null,
                'shoe_video' => $isSpecialShoe ? 'shoe_video.mp4' : null,
                'shoe_description' => "This is the best {$shoe[2]} shoe, model {$shoe[0]}",
                'category_name' => $shoe[3],
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now()->subDays(rand(1, 10)),
            ]);
        }
    }

}
