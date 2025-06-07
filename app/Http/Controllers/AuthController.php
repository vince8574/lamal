<?php

namespace App\Http\Controllers;

use App\Actions\CreateAnonymousUserAction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create($fields);

        $token = $user->createToken($request->name);


        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'token_name' => 'nullable|string|max:255',
        ]);

        $token_name = $request->get('token_name') ?? 'default_token_name';
        $email = $request->get('email');
        $password = $request->get('password');

        // Unique key for rate limiting based on email
        $rateLimitKey = 'login_attempts:' . $email;
        $lockoutKey = 'login_lockout:' . $email;

        // Check if the user is currently in a lockout period
        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $remainingSeconds = RateLimiter::availableIn($rateLimitKey);

            return response()->json([
                'message' => 'Trop de tentatives de connexion. Veuillez réessayer dans ' . $this->formatTime($remainingSeconds) . '.',
                'lockout' => true,
                'remaining_seconds' => $remainingSeconds,
                'retry_after' => now()->addSeconds($remainingSeconds)->toISOString()
            ], 429);
        }

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            // Increment the failed attempts counter
            RateLimiter::hit($rateLimitKey, 60); // 60 seconds = 1 minute lockout

            $attempts = RateLimiter::attempts($rateLimitKey);
            $remainingAttempts = 5 - $attempts;

            if ($remainingAttempts <= 0) {
                $remainingSeconds = RateLimiter::availableIn($rateLimitKey);

                return response()->json([
                    'message' => 'Trop de tentatives de connexion échouées. Votre compte est temporairement bloqué pendant ' . $this->formatTime($remainingSeconds) . '.',
                    'lockout' => true,
                    'remaining_seconds' => $remainingSeconds,
                    'retry_after' => now()->addSeconds($remainingSeconds)->toISOString()
                ], 429);
            }

            return response()->json([
                'message' => 'Identifiants invalides.',
                'remaining_attempts' => $remainingAttempts,
                'warning' => $remainingAttempts <= 2 ?
                    "Attention : il vous reste seulement {$remainingAttempts} tentative(s) avant le blocage temporaire." : null
            ], 401);
        }

        // Successful login - reset the counter
        RateLimiter::clear($rateLimitKey);
        $token = $user->createToken($token_name);


        return [
            'user' => $user,
            'token' => $token->plainTextToken,
        ];
    }

    /**
     * Format the time in a human-readable format.
     *     
     */
    private function formatTime(int $seconds): string
    {
        if ($seconds < 60) {
            return $seconds . ' seconde' . ($seconds > 1 ? 's' : '');
        }

        $minutes = floor($seconds / 60);
        $remainingSeconds = $seconds % 60;

        $timeString = $minutes . ' minute' . ($minutes > 1 ? 's' : '');

        if ($remainingSeconds > 0) {
            $timeString .= ' et ' . $remainingSeconds . ' seconde' . ($remainingSeconds > 1 ? 's' : '');
        }

        return $timeString;
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out successfully',
        ];
    }
}
