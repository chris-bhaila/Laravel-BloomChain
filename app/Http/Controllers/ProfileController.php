<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user()
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|strin|max:255',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ]);

        return back()->with('success', 'Profile updated successfully!');
    }
}
