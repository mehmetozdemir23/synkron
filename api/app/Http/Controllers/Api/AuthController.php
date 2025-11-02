<?php

namespace App\Http\Controllers\Api;

use App\Actions\AuthenticateGoogleUserAction;
use App\Actions\LoginUserAction;
use App\Actions\RegisterUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function register(RegisterUserRequest $request, RegisterUserAction $action): JsonResponse
    {
        $user = $action->handle($request->validated());

        auth()->login($user);

        return response()->json([
            'user' => $user,
            'message' => 'Inscription réussie',
        ], 201);
    }

    public function login(LoginUserRequest $request, LoginUserAction $action): JsonResponse
    {
        $result = $action->handle($request->validated());

        auth()->login($result['user']);

        return response()->json([
            'user' => $result['user'],
            'message' => 'Connexion réussie',
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        if ($request->hasSession()) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return response()->json(['message' => 'Déconnecté avec succès.']);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json(['user' => $request->user()]);
    }

    public function googleRedirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback(AuthenticateGoogleUserAction $action): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = $action->handle([
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
            ]);

            auth()->login($user);

            $frontendUrl = config('app.frontend_url', 'http://localhost:5173');

            return redirect($frontendUrl.'/dashboard');
        } catch (Exception $e) {
            Log::error('Google OAuth authentication failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $frontendUrl = config('app.frontend_url', 'http://localhost:5173');
            $errorMessage = 'Erreur lors de l\'authentification Google: '.$e->getMessage();

            return redirect($frontendUrl.'/login?error='.urlencode($errorMessage));
        }
    }
}
