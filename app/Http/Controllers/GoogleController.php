<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    //Redirecting user to google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    //Handling google callback
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Google authentication failed'], 401);
        }
        $user = User::where('google_id', $googleUser->getId())->first();

        if (!$user) {
            $user = User::updateOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'name'     => $googleUser->getName(),
                    'email'    => $googleUser->getEmail(),
                    'avatar'   => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(32)),
                ]
            );
        }

        Auth::login($user);

        // Issue Sanctum token
        $token = $user->createToken('nmc-token')->plainTextToken;

        // Detect if request is coming from the mobile app
        $isMobile = request()->query('source') === 'mobile';

        if ($isMobile) {
            return redirect('myapp://auth/google/callback?token=' . urlencode($token));
        }

        // Normal web flow
        if ($user->subscription_type === 'admin') {
            return redirect()->route('admin.dashboard')->cookie('auth_token', $token, 60 * 24);
        }

        if (!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
            return redirect()->route('verification.notice')->cookie('auth_token', $token, 60 * 24);
        }

        return redirect('/dashboard')->cookie('auth_token', $token, 60 * 24);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // revoke all tokens for this user
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
