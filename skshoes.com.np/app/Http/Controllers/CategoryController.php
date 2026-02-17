<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Shoe;
use Exception;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    //Give Category Data
    public function index() {
        try{
            $categories = Category::all(); 
            $categoryData = $categories->map(function($category) {
                return [
 
                    "name" => $category->category_name,
                    "image_url" => "/assets/images/categories/{$category->category_image}",
                    "featured" => $category->feature == 1 ? true : false,
                ];
            });
            return response()->json(["Categories" => $categoryData]);
        }catch(Exception $e){
            return response()->json(["Error"=> $e->getMessage()]);
        }
    }
    

     //For the Home Page Customer
    public function home()
    {
        $categories = Category::where('feature',true)->get();
        $latests =Shoe::orderByDesc('updated_at')->take(6)->with(['prices' => function ($query) {
                    $query->orderBy('price', 'asc')->select('article_id', 'price');
        }])->get();
        return view('customer.welcome', [
            'categories' => $categories,
            'latests' => $latests,
        ]);
    }

    //Creating New Category For Admin
    public function store(Request $request)
    {
        try {
            
            $category_name = $request->input('category_name');
            $image = $request->file('category_image');
        
            $image_name = str_replace(' ', '_', $category_name) .'.webp';
            $image->move(public_path('assets/images/categories'), $image_name);

            $category = new Category();
            $category->category_name = $category_name;
            $category->category_image = $image_name;
            $category->feature = $request->input('feature', null);
            $category->save();

            return response()->json(['message' => 'Category created successfully'], 200);
        
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    //Category Search
    public function categoryList(Request $request)
    {
        try {
            $categories = Category::select('category_name')->get(); // Fetch data

            $categoryData = $categories->map(function ($category) {
                return [
                    "name" => $category->category_name,
                ];
            });

            return response()->json(["Categories" => $categoryData], 200);
        } catch (Exception $e) {
            return response()->json(["Error" => $e->getMessage()], 500);
        }
    }



    //Update Category Details
     public function update(Request $request, $category_name)
    {
        $new_categoryName = $request->input('new_categoryName', null);
        $new_categoryImage = $request->file('category_image', null);
        $new_categoryFeature = $request->input('feature', null);

        try{
        $categoryQuery = Category::where('category_name', $category_name)->first();

        if (!$categoryQuery) {
            return response()->json(["error" => "Category not found"], 404);
        }


        if ($new_categoryImage !== null) {
            $oldImagePath = public_path('assets/images/categories/' . $categoryQuery->category_image);

            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                unlink($oldImagePath);
            }

            if ($new_categoryName !== null) {
                $imageExtension = $new_categoryImage->getClientOriginalExtension();
                $image_name = str_replace(' ', '_',$new_categoryName.'.'. $imageExtension);
            }else{
                $image_name = $categoryQuery->category_image;
            }
            
            $new_categoryImage->move(public_path('assets/images/categories'), $image_name);
            $categoryQuery->category_image = $image_name;
        }
        
        if ($new_categoryName !== null) {
            $categoryQuery->category_name = $new_categoryName;
            $oldImagePath = public_path('assets/images/categories/' . $categoryQuery->category_image);
            if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                $imageExtension = pathinfo($categoryQuery->category_image, PATHINFO_EXTENSION);

                $newImageName = str_replace(' ', '_', $new_categoryName) . '.' . $imageExtension;
                
                $newImagePath = public_path('assets/images/categories/' . $newImageName);
                rename($oldImagePath, $newImagePath);
                
                $categoryQuery->category_image = $newImageName;
            }
        }

        if ($new_categoryFeature !== null) {
            $categoryQuery->feature = $new_categoryFeature;
        }

        $categoryQuery->save();

        return response()->json([
            "message" => "Category updated successfully",
            "updated_category" => $categoryQuery
        ]);
        }catch(Exception $e){
            return response()->json(["Error"=> $e->getMessage()]);
        }

    }

    //Deliting Category Admin Side
    public function destroy($category_name)
    {
        try {
            $shoeQuery = Shoe::where('category_name', $category_name)->get();
        
            foreach ($shoeQuery as $shoe) {
                $folderPath = public_path('assets/images/products/' . $shoe->article_id);
                
                if (File::exists($folderPath)) {
                    File::deleteDirectory($folderPath); // Deletes the folder and all its contents
                }
            }
            $categoryQuery = Category::where('category_name', $category_name)->first();
            if ($categoryQuery) {
                $categoryImagePath = public_path('assets/images/categories/' . $categoryQuery->category_image);
                if (file_exists($categoryImagePath)) {
                    unlink($categoryImagePath);
                }
                
                $categoryQuery->delete();
            }
        
            return response()->json(["Successfully Deleted" => "$category_name and its corresponding data"]);
        } catch (Exception $e) {
            return response()->json(["Error" => $e->getMessage()]);
        }


    }
}
