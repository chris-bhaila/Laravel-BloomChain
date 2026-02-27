<?php

namespace App\Http\Controllers;

use App\Models\Nursery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NurseryController extends Controller
{
    public function create()
    {
        if (Auth::user()->nursery) {
            return redirect()->route('nursery.show')
                ->with('error', 'You already have a nursery.');
        }

        return view('pages.dashboard.sidebar', [
            'page' => 'nurseries.create',
        ]);
    }

    public function store(Request $request)
    {
        if (Auth::user()->nursery) {
            return redirect()->back()
                ->with('error', 'You already have a nursery and cannot create another.');
        }

        $request->validate([
            'name'        => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'phone'       => ['required', 'regex:/^\+?[0-9]{7,15}$/'],
            'email'       => ['required', 'string', 'email', 'max:255'],
            'location'    => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\,\.\-]+$/'],
            'description' => ['nullable', 'string', 'max:1000'],
            'reg-cer'     => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'pan-cer'     => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ], [
            'name.regex'     => 'Nursery name may only contain letters, spaces, and hyphens.',
            'phone.regex'    => 'Please enter a valid phone number (e.g. +9779800000000).',
            'location.regex' => 'Location may only contain letters, numbers, spaces, commas, periods, and hyphens.',
            'reg-cer.required' => 'Registration certificate is required.',
            'pan-cer.required' => 'PAN certificate is required.',
        ]);

        $regCerFile = $request->file('reg-cer');
        $regCerName = time() . '_reg.' . $regCerFile->getClientOriginalExtension();
        $regCerFile->storeAs('nursery_priv_docs', $regCerName);

        $panCerFile = $request->file('pan-cer');
        $panCerName = time() . '_pan.' . $panCerFile->getClientOriginalExtension();
        $panCerFile->storeAs('nursery_priv_docs', $panCerName);

        Nursery::create([
            'user_id'       => Auth::id(),
            'name'          => $request->name,
            'contact_phone' => $request->phone,
            'contact_email' => $request->email,
            'location'      => $request->location,
            'description'   => $request->description,
            'reg_cer'       => $regCerName,
            'pan_cer'       => $panCerName,
        ]);

        return redirect()->route('nursery.show')
            ->with('success', 'Nursery created successfully!');
    }

    public function viewFile($filename)
    {
        $nursery = Nursery::where('reg_cer', $filename)
            ->orWhere('pan_cer', $filename)
            ->firstOrFail();

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