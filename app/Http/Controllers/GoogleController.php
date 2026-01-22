<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

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
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('google_id', $googleUser->getId())->first();

        if(!$user) {
            $user = User::updateOrCreate(
                ['google_id' => $googleUser->getId()],
                [
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'avatar' => $googleUser->getAvatar(),
                    'password' => bcrypt(Str::random(32)),
                ]
            );

        }

        Auth::login($user);

        return redirect('/landing');
    }
}
