<?php

namespace App\Http\Controllers;

use App\Models\Nursery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NurseryController extends Controller
{
    public function index()
    {
        $nurseries = Nursery::where('user_id', Auth::id())->get();

        return view('nurseries.index', compact('nurseries'));
    }

    public function create()
    {
        return view('nurseries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        Nursery::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return redirect()->route('nurseries.index')->with('success','Nursery added!');
    }
}
