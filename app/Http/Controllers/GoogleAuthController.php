<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class GoogleAuthController extends Controller
{
    // Step 1: Redirect to Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Step 2: Handle Google callback
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        // Find the CR in your registration table
        $cr = Registration::where('email', $googleUser->getEmail())
            ->where('role', 'cr')
            ->first();

        if (!$cr) {
            return redirect()->route('login')->with('error', 'You are not registered as a CR.');
        }

        // Log in the CR
        Auth::login($cr);

        // Store year and branch in session
        session([
            'year' => $cr->year,
            'branch' => $cr->branch,
        ]);

        return redirect()->route('cr.dashboard')->with('success', 'Logged in successfully!');
    }
}
