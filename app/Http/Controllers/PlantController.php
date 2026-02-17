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
            'description' => 'nullable|string'
        ]);

        $nursery->plants()->create([
            'name' => $request->name,
            'category' => $request->category,
            'description' => $request->description,
            'price' => $request->price,
            'stock_quantity' => $request->stock_quantity,
            'scientific_name' => $request->scientific_name,
            'sunlight_requirement' => $request->sunlight_requirement,
            'water_requirement' => $request->water_requirement,
        ]);

        return redirect()
            ->route('nursery.show', $nursery->id)
            ->with('success', 'Plant added successfully!');
    }
}
