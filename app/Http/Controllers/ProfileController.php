<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('pages.dashboard.sidebar', [
            'page' => 'settings.editProfile',
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
            'email'   => ['required', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'phone'   => ['nullable', 'regex:/^\+?[0-9]{7,15}$/'],
            'address' => ['nullable', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\,\.\-]+$/'],
        ], [
            'name.regex'    => 'Name may only contain letters, spaces, and hyphens.',
            'phone.regex'   => 'Please enter a valid phone number (e.g. +9779800000000).',
            'address.regex' => 'Address may only contain letters, numbers, spaces, commas, periods, and hyphens.',
        ]);

        Auth::user()->update($request->only('name', 'email', 'phone', 'address'));

        return back()->with('success', 'Profile updated successfully!');
    }

    public function verify()
    {
        if (Auth::user()->verification_status === 'verified') {
            return redirect()->route('dashboard');
        }

        return view('pages.dashboard.sidebar', [
            'page' => 'settings.verification',
        ]);
    }

    public function storeVerification(Request $request)
    {
        if (Auth::user()->verification_status === 'verified') {
            return redirect()->route('dashboard');
        }

        $request->validate([
            'phone'   => ['required', 'regex:/^\+?[0-9]{7,15}$/'],
            'address' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\,\.\-]+$/'],
        ], [
            'phone.regex'   => 'Please enter a valid phone number (e.g. +9779800000000).',
            'address.regex' => 'Address may only contain letters, numbers, spaces, commas, periods, and hyphens.',
        ]);

        Auth::user()->update([
            'phone'               => $request->phone,
            'address'             => $request->address,
            'verification_status' => 'verified',
        ]);

        return redirect()->route('dashboard')->with('success', 'Account verified successfully!');
    }
}