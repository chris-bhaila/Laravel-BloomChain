<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Price;
use App\Models\Shoe;


class ShoeController extends Controller
{
    //Customer Side All Products
    public function index(Request $request)
    {
        try {
            $shoesQuery = Shoe::with(['prices' => function ($query) { 
                    $query->with('stocks');
                    $query->orderBy('price', 'asc')->limit(20);
            }])->select(['article_id', 'shoe_name', 'shoe_color', 'shoe_image1', 'category_name']);

            if ($request->has('search')) {
                $search = $request->input('search');
                $shoesQuery->where('shoe_name', 'LIKE', "%{$search}%");
            }
            
            if ($request->has('price_min') || $request->has('price_max')) {
                $shoesQuery->whereHas('prices', function ($query) use ($request) {
                    $query->whereBetween('price', [$request->input('price_min')??0, $request->input('price_max')]);
                });
            }
            
            if ($request->has('categories')) {
                $categories = explode(',', $request->input('categories'));
                $shoesQuery->whereIn('category_name', $categories);
            }

            if ($request->has('sizes')) {

                $shoesQuery->with(['prices' => function ($query) {
                    $query->with('stocks'); 
                }]);
                $sizes = explode(',', $request->input('sizes'));
            
                $shoesQuery->whereHas('prices.stocks', function ($query) use ($sizes) {
                    $query->whereIn('size', $sizes);
                });
            }
            
            if ($request->has('sort')) {
                switch ($request->input('sort')) {
                    case 'low':
                        $shoesQuery->orderByRaw('(SELECT MIN(price) FROM prices WHERE prices.article_id = shoes.article_id) ASC');
                        break;
                    case 'high':
                        $shoesQuery->orderByRaw('(SELECT MIN(price) FROM prices WHERE prices.article_id = shoes.article_id) DESC');
                        break;
                    case 'latest':
                        $shoesQuery->orderBy('created_at', 'desc');
                        break;
                    default:
                        break;
                }
            }

            $shoes = $shoesQuery->paginate(20);
            
            $formattedShoes = collect($shoes->items())->map(function ($shoe) {
                return [
                    'article_id' => $shoe->article_id,
                    'shoe_name' => $shoe->shoe_name,
                    'shoe_color' => $shoe->shoe_color,
                    'shoe_image' => "/assets/images/products/" . $shoe->article_id . "/" . $shoe->shoe_image1,
                    'category_name' => $shoe->category_name,
                    'price' => $shoe->prices->min('price'),
                ];
            });

            return view('customer.products',[
                'Shoes' => $formattedShoes,
                'pagination' => [
                    'total' => $shoes->total(),
                    'per_page' => $shoes->perPage(),
                    'current_page' => $shoes->currentPage(),
                    'last_page' => $shoes->lastPage(),
                    'next_page_url' => $shoes->nextPageUrl(),
                    'prev_page_url' => $shoes->previousPageUrl(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    //Adding Shoe Data Admin
    public function store(Request $request)
    {
        $article_id = $request->input('article_id');
        $shoe_name = $request->input('product_name');
        $shoe_color = $request->input('product_color');
        $shoe_video = $request->file('shoe_video');
        $shoe_description = $request->input('shoe_description');
        $category_name = $request->input('category_name');
        $price_combinations = json_decode($request->input('price_combinations'), true);

        $imagePath = public_path('assets/images/products/' . $article_id);
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0777, true);
        }
        $shoe_images = [];
        foreach (range(1, 6) as $i) {
            $file = $request->file("shoe_image$i");
            if ($file) {
                $fileName = "image$i." . "webp";
                $file->move($imagePath, $fileName);
                $shoe_images["shoe_image$i"] = $fileName;
            } else {
                $shoe_images["shoe_image$i"] = null;
            }
        }
        $video_extension = null;
        $shoeAdd = null;
        if ($shoe_video) {
            $video_extension =  $shoe_video->getClientOriginalExtension();
            $shoe_video->move(public_path('assets/images/products/' . $article_id),'shoe_video.'. $video_extension);
            $shoeAdd = 'shoe_video';
        }
        

        try {
            DB::beginTransaction();
            $shoe = new Shoe();
            $shoe->article_id = $article_id;
            $shoe->shoe_name = $shoe_name;
            $shoe->shoe_color = $shoe_color;
            foreach ($shoe_images as $key => $value) {
                $shoe->$key = $value;
            }
            $shoe->shoe_video = $shoeAdd;
            $shoe->shoe_description = $shoe_description;
            $shoe->category_name = $category_name;
            $shoe->save();

            if (!empty($price_combinations)) {
                foreach ($price_combinations as $combination) {
                    if ($combination['grouping'] !== null) {
                        Price::create([
                            'article_id' => $article_id,
                            'product_grouping' => json_encode($combination['grouping']),
                            'price' => $combination['price'],
                        ]);
                    }else{
                        Price::create([
                            'article_id' => $article_id,
                            'product_grouping' => null,
                            'price' => $combination['price'],
                        ]);
                    }
                    
                }
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            try {
                Shoe::where('article_id', $article_id)->firstOrFail();
            } catch (Exception $f) {
        
                $imagePath = public_path('assets/images/products/' . $article_id);
                if (file_exists($imagePath)) {
                    $files = glob($imagePath . '/*');
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }
                    rmdir($imagePath);
                }
            }
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Product created successfully']);
    }


     //Admin Side Inside Product Display Product List
     public function show(Request $request){
        $article_id = $request->input('article_id');
        try {

            if($article_id){
                $articleQuery = Shoe::where('article_id', 'like', "%$article_id%")
                ->select('article_id', 'category_name', 'shoe_description', 'shoe_image1')
                ->get(); 
                return response()->json($articleQuery->map(function ($article) {
                    return [
                        'article_id'  => $article->article_id,
                        'category'    => $article->category_name,
                        'description' => $article->shoe_description,
                        'image'       => $article->shoe_image1,
                    ];
                }));
            }else{
                $articleQuery = Shoe::select('article_id', 'category_name', 'shoe_description', 'shoe_image1')
                ->get(); 
                return response()->json($articleQuery->map(function ($article) {
                    return [
                        'article_id'  => $article->article_id,
                        'category'    => $article->category_name,
                        'description' => $article->shoe_description,
                        'image'       => $article->shoe_image1,
                    ];
                }));
            }
        }catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function productDetail(Request $request, $article_id){
        // $article_id = $request->input('article_id');
        try {
            $shoeQuery = Shoe::where('article_id', $article_id)
                            ->with(['prices' => function ($query) {
                                $query->select('price_id', 'article_id', 'product_grouping', 'price');
                            }])
                            ->select('article_id', 'shoe_name', 'shoe_color', 'shoe_image1', 'shoe_image2', 'shoe_image3', 'shoe_image4', 'shoe_image5', 'shoe_image6', 'shoe_video', 'shoe_description', 'category_name')
                            ->get();
    
            if ($shoeQuery->isEmpty()) {
                return response()->json(["message" => "No products found"], 404);
            }
    
            return response()->json($shoeQuery->map(function ($shoe) {
                return [
                    'article_id'      => $shoe->article_id,
                    'shoe_name'       => $shoe->shoe_name,
                    'shoe_color'      => $shoe->shoe_color,
                    'shoe_image1'     => $shoe->shoe_image1,
                    'shoe_image2'     => $shoe->shoe_image2,
                    'shoe_image3'     => $shoe->shoe_image3,
                    'shoe_image4'     => $shoe->shoe_image4,
                    'shoe_image5'     => $shoe->shoe_image5,
                    'shoe_image6'     => $shoe->shoe_image6,
                    "video" => $shoe->shoe_video ? "/assets/images/products/{$shoe->article_id}/{$shoe->shoe_video}" : null,
                    'shoe_description'=> $shoe->shoe_description,
                    'category_name'   => $shoe->category_name,
                    'prices'          => $shoe->prices->map(function ($price) {
                        return [
                            'price_id'         => $price->price_id,
                            'product_grouping' => json_decode($price->product_grouping, true), // Decode JSON
                            'price'            => $price->price,
                        ];
                    }),
                ];
            }));
        }catch(Exception $e){
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
    

    //Admin Side Update Product
    public function update(Request $request, $article)
    {
        $article_id = $request->input('article_id');
        // $new_article_id = $request->input('new_article_id', null);
        $shoe_name = $request->input('shoe_name', null);
        $shoe_color = $request->input('shoe_color', null);
        $shoe_image1 = $request->file('shoe_image1', null);
        $shoe_image2 = $request->file('shoe_image2', null);
        $shoe_image3 = $request->file('shoe_image3', null);
        $shoe_image4 = $request->file('shoe_image4', null);
        $shoe_image5 = $request->file('shoe_image5', null);
        $shoe_image6 = $request->file('shoe_image6', null);
        $shoe_video = $request->file('shoe_video', null);
        $shoe_description = $request->input('shoe_description', null);
        $category_name = $request->input('category_name', null);
        $product_grouping = $request->input('price_combinations', null);

        dd($request->all());
        try{
         $shoeQuery = Shoe::where('article_id', $article)->firstOrFail();
        }catch(Exception $e){
            return response()->json(["error" => $e->getMessage()]);
        }
        if ($shoe_name || $shoe_color || $shoe_description || $category_name) {
            $shoeQuery->shoe_name = $shoe_name ?? $shoeQuery->shoe_name;
            $shoeQuery->shoe_color = $shoe_color ?? $shoeQuery->shoe_color;
            $shoeQuery->shoe_description = $shoe_description ?? $shoeQuery->shoe_description;
            $shoeQuery->category_name = $category_name ?? $shoeQuery->category_name;
            $shoeQuery->save(); 
        }
        if ($shoe_image1 || $shoe_image2 || $shoe_image3 || $shoe_image4 || $shoe_image5 || $shoe_image6 || $shoe_video) {
            $shoePath = $shoeQuery->article_id;
            for ($i = 1; $i <= 6; $i++) {
                $shoe_image_key = 'shoe_image' . $i; 
                if ($request->hasFile($shoe_image_key)) {
                    $oldImagePath = public_path('assets/images/products/' . $shoePath . '/' . $shoeQuery->$shoe_image_key);
                    
                    if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $newImage = $request->file($shoe_image_key);
                    $imageExtension = $newImage->getClientOriginalExtension();
                    $image_name = 'image' . $i . '.' . $imageExtension;
                    $newImage->move(public_path('assets/images/products/' . $shoePath), $image_name);
                    $shoeQuery->$shoe_image_key = $image_name;
                }
            }
            if ($shoe_video) {
                $oldVideoPath = public_path('assets/images/products/' . $shoePath . '/' . $shoeQuery->shoe_video);
                if (file_exists($oldVideoPath) && is_file($oldVideoPath)) {
                    unlink($oldVideoPath);
                }
                $videoExtension = $shoe_video->getClientOriginalExtension();
                $video_name = 'shoe_video.' . $videoExtension;
                $shoe_video->move(public_path('assets/images/products/' . $shoePath), $video_name);
                $shoeQuery->shoe_video = $video_name;
            }
            $shoeQuery->save();
        }
        if($product_grouping){
            foreach ($product_grouping as $combination) {
                try {
                    if (!empty($combination['price_id'])) {
                        $priceQuery = Price::where('price_id', $combination['price_id'])->first();
                        if ($priceQuery) {
                            $priceQuery->product_grouping = isset($combination['grouping']) 
                                ? json_encode($combination['grouping']) 
                                : null;
                            $priceQuery->price = $combination['price'];
                            $priceQuery->save();
                        }
                    } else {
                        Price::create([
                            'article_id' => $article_id,
                            'product_grouping' => isset($combination['grouping']) 
                                ? json_encode($combination['grouping'])
                                : null,
                            'price' => $combination['price'],
                        ]);
                    }
                } catch (Exception $e) {
                    return response()->json([
                        'error' => 'Price update or insert failed',
                        'message' => $e->getMessage()
                    ], 500);
                }
            }
            
        }
        return response()->json(["success" => "Shoe updated successfully."]);
    }

    public function destroy(Request $request, $article_id)
    {
        $price_id = $request->input('price_id');
        
        try{
            $shoeQuery = Shoe::where('article_id', $article_id)->firstOrFail();
            $folderPath = public_path('assets/images/products/' . $shoeQuery->article_id);
                
                if (File::exists($folderPath)) {
                    File::deleteDirectory($folderPath);
                }
            $shoeQuery->delete();

            if($price_id){
                $priceQuery = Price::where('price_id', $price_id)->firstOfFail();
                return response()->json(["success" => $price_id]);
            }
            return response()->json(["success" => $article_id]);
        }catch(Exception $e){
            return response()->json(["error" => $e->getMessage()]);

        }
    }

    public function api(Request $request)
    {
        try {
            $shoesQuery = Shoe::with(['prices' => function ($query) {
                $query->with('stocks');
                $query->orderBy('price', 'asc')->limit(20);
            }])->select(['article_id', 'shoe_name', 'shoe_color', 'shoe_image1', 'category_name']);

            if ($request->has('search')) {
                $search = $request->input('search');
                $shoesQuery->where('shoe_name', 'LIKE', "%{$search}%");
            }

            if ($request->has('price_min') || $request->has('price_max')) {
                $shoesQuery->whereHas('prices', function ($query) use ($request) {
                    $query->whereBetween('price', [$request->input('price_min') ?? 0, $request->input('price_max')]);
                });
            }

            if ($request->has('categories')) {
                $categories = explode(',', $request->input('categories'));
                $shoesQuery->whereIn('category_name', $categories);
            }

            if ($request->has('sizes')) {

                $shoesQuery->with(['prices' => function ($query) {
                    $query->with('stocks');
                }]);
                $sizes = explode(',', $request->input('sizes'));

                $shoesQuery->whereHas('prices.stocks', function ($query) use ($sizes) {
                    $query->whereIn('size', $sizes);
                });
            }

            if ($request->has('sort')) {
                switch ($request->input('sort')) {
                    case 'low':
                        $shoesQuery->orderByRaw('(SELECT MIN(price) FROM prices WHERE prices.article_id = shoes.article_id) ASC');
                        break;
                    case 'high':
                        $shoesQuery->orderByRaw('(SELECT MIN(price) FROM prices WHERE prices.article_id = shoes.article_id) DESC');
                        break;
                    case 'latest':
                        $shoesQuery->orderBy('created_at', 'desc');
                        break;
                    default:
                        break;
                }
            }

            $shoes = $shoesQuery->paginate(20);

            $formattedShoes = collect($shoes->items())->map(function ($shoe) {
                return [
                    'article_id' => $shoe->article_id,
                    'shoe_name' => $shoe->shoe_name,
                    'shoe_color' => $shoe->shoe_color,
                    'shoe_image' => "/assets/images/products/" . $shoe->article_id . "/" . $shoe->shoe_image1,
                    'category_name' => $shoe->category_name,
                    'price' => $shoe->prices->min('price'),
                ];
            });

            return response()->json([
                'Shoes' => $formattedShoes,
                'pagination' => [
                    'total' => $shoes->total(),
                    'per_page' => $shoes->perPage(),
                    'current_page' => $shoes->currentPage(),
                    'last_page' => $shoes->lastPage(),
                    'next_page_url' => $shoes->nextPageUrl(),
                    'prev_page_url' => $shoes->previousPageUrl(),
                ],
            ]);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }
}