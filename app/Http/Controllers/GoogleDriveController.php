<?php
// app/Http/Controllers/GoogleDriveController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Illuminate\Support\Facades\Log;
use App\Models\User;
class GoogleDriveController extends Controller
{
    public function redirectToGoogle()
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->addScope(GoogleDrive::DRIVE_FILE);

        // IMPORTANT: Ask for refresh token
        $client->setAccessType('offline');   // get refresh_token
        $client->setPrompt('consent');       // force showing consent to get refresh_token

        $authUrl = $client->createAuthUrl();
        return redirect($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $code = $request->get('code');
        if (!$code) {
            return redirect()->route('google.login')->with('error', 'Authorization failed.');
        }

        $tokens = $client->fetchAccessTokenWithAuthCode($code);
        if (isset($tokens['error'])) {
            Log::error('Google token error', $tokens);
            return redirect()->route('google.login')->with('error', 'Failed to fetch token from Google.');
        }

        // Save to DB on current user
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('cr.Upload')->with('error', 'Please login first.');
        }

        $user->google_access_token = $tokens['access_token'] ?? null;
        // refresh_token may not be returned if Google thinks you already granted it.
        // 'prompt=consent' typically forces one. Keep old one if missing.
        if (!empty($tokens['refresh_token'])) {
            $user->google_refresh_token = $tokens['refresh_token'];
        }
        $user->google_token_expires_at = now()->addSeconds($tokens['expires_in'] ?? 3600);
        $user->save();

        return redirect()->route('cr.Upload')->with('success', 'Google Drive connected!');
    }
}
