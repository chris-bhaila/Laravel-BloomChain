<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use App\Models\Nursery;

use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function create(Nursery $nursery)
    {
        return view('pages.dashboard.dashboard', [
            'page' => 'nurseries.plants.create',
            'nursery' => $nursery
        ]);
    }

    public function store(Request $request, Nursery $nursery)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'plant-image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category' => 'nullable|string|max:255',
            'price' => 'nullable|numeric',
            'stock_quantity' => 'nullable|integer',
            'scientific_name' => 'nullable|string|max:255',
            'sunlight_requirement' => 'nullable|string|max:255',
            'water_requirement' => 'nullable|string|max:255',
        ]);

        $plantImgName = null;

        if ($request->hasFile('plant_image')) {
            $plantImgFile = $request->file('plant_image'); // use underscore
            $plantImgName = time() . '_plant.' . $plantImgFile->getClientOriginalExtension();
            $plantImgFile->storeAs('plant_images', $plantImgName);
        }


        $nursery->plants()->create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'category' => $request->category,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'scientific_name' => $request->scientific_name,
            'sunlight_requirement' => $request->sunlight_requirement,
            'water_requirement' => $request->water_requirement,
            'image' => $plantImgName, // save stored filename
        ]);

        return redirect()
            ->route('nursery.show', $nursery->id)
            ->with('success', 'Plant added successfully!');
    }

    public function viewFile($filename)
    {
        // $plant = Plant::where('image', $filename)->firstOrFail();

        $filePath = storage_path('app/private/plant_images/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->file($filePath);
    }
}
