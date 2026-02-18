<?php

namespace App\Http\Controllers;

use App\Models\Nursery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NurseryController extends Controller
{
    public function index()
    {
        $nurseries = Nursery::where('user_id', Auth::id())
            ->withCount('plants') // adds a 'plant_count' property to each nursery
            ->get();

        // Dashboard dynamic route expects data only, not view
        if (request()->routeIs('dashboard.nurseries')) {
            return ['nurseries' => $nurseries];
        }

        // Otherwise, standalone view (if ever needed)
        return view('pages.dashboard.nurseries.index', compact('nurseries'));
    }


    public function create()
    {
        return view('nurseries.create');
    }

    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'email' => 'required|string|email|max:255',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'reg-cer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'pan-cer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle file uploads
        $regCerFile = $request->file('reg-cer');
        $regCerName = time() . '_reg.' . $regCerFile->getClientOriginalExtension();
        $regCerFile->storeAs('nursery_priv_docs', $regCerName);

        $panCerFile = $request->file('pan-cer');
        $panCerName = time() . '_pan.' . $panCerFile->getClientOriginalExtension();
        $panCerFile->storeAs('nursery_priv_docs', $panCerName);

        // Create nursery record
        Nursery::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'contact_phone' => $request->phone,
            'contact_email' => $request->email,
            'location' => $request->location,
            'description' => $request->description,
            'reg_cer' => $regCerName,
            'pan_cer' => $panCerName,
        ]);

        return redirect()->route('dashboard.nurseries', ['page' => 'index'])
            ->with('success', 'Nursery added successfully!');
    }

    public function viewFile($filename)
    {
        // Find the nursery that owns this file
        $nursery = Nursery::where('reg_cer', $filename)
            ->orWhere('pan_cer', $filename)
            ->firstOrFail();

        // Only allow the owner to view
        if ($nursery->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $filePath = storage_path('app/private/nursery_priv_docs/' . $filename);

        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->file($filePath);
    }
}
