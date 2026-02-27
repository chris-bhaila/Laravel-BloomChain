<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function create()
    {
        $nursery = Auth::user()->nursery;

        if (!$nursery) {
            return redirect()->route('nurseries.create')
                ->with('error', 'You need to create a nursery first.');
        }

        return dashboardView('nurseries.plants.create', ['nursery' => $nursery]);
    }

    public function store(Request $request)
    {
        $user = Auth::id();
        $nursery = Auth::user()->nursery;

        if (!$nursery) {
            return redirect()->route('nurseries.create')
                ->with('error', 'You need to create a nursery first.');
        }

        if (Auth::user()->subscription_type === 'general' && $nursery->plants()->count() >= 5) {
            return redirect()->back()
                ->with('error', 'Free accounts are limited to 5 plants. Upgrade to premium to add more.');
        }

        $request->validate([
            'name'                 => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'description'          => ['nullable', 'string', 'max:1000'],
            'plant_image'          => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'category'             => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'offer_price'          => ['required', 'numeric', 'min:0', 'max:999999'],
            'selling_price'        => ['required', 'numeric', 'min:0', 'max:999999'],
            'stock_quantity'       => ['required', 'integer', 'min:0', 'max:99999'],
            'best_season'          => ['nullable', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'scientific_name'      => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-\.]+$/u'],
            'sunlight_requirement' => ['nullable', 'string', 'max:255'],
            'water_requirement'    => ['nullable', 'string', 'max:255'],
        ], [
            'name.regex'            => 'Plant name may only contain letters, spaces, and hyphens.',
            'category.regex'        => 'Category may only contain letters, spaces, and hyphens.',
            'scientific_name.regex' => 'Scientific name may only contain letters, spaces, hyphens, and periods.',
            'offer_price.min'       => 'Price cannot be negative.',
            'selling_price.min'     => 'Price cannot be negative.',
            'stock_quantity.min'    => 'Stock quantity cannot be negative.',
            'best_season.regex'     => 'Season name may only contain letters, spaces, and hyphens.',
        ]);

        $plantImgName = null;

        if ($request->hasFile('plant_image')) {
            $file = $request->file('plant_image');
            $plantImgName = $user . '_' . time() . '_plant.' . $file->getClientOriginalExtension();
            $file->storeAs($user, $plantImgName, 'local');
        }

        $nursery->plants()->create([
            'name'                 => $request->name,
            'description'          => $request->description,
            'category'             => $request->category,
            'offer_price'          => $request->offer_price,
            'selling_price'        => $request->selling_price,
            'stock_quantity'       => $request->stock_quantity,
            'best_season'          => $request->best_season,
            'scientific_name'      => $request->scientific_name,
            'sunlight_requirement' => $request->sunlight_requirement,
            'water_requirement'    => $request->water_requirement,
            'image'                => $plantImgName,
        ]);

        return redirect()
            ->route('nursery.show')
            ->with('success', 'Plant added successfully!');
    }

    public function viewFile($filename)
    {
        $user = Auth::id();
        $path = $user . '/' . $filename;

        if (!Storage::disk('local')->exists($path)) {
            abort(404);
        }

        return response()->file(Storage::disk('local')->path($path));
    }
}
