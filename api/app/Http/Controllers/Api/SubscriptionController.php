<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function status(Request $request): JsonResponse
    {
        $user = $request->user();

        $subscriptionData = null;

        if ($user->isPro()) {
            $subscription = $user->subscription(User::PLAN_PRO);

            if ($subscription) {
                $subscriptionData = [
                    'type' => $subscription->type,
                    'stripe_status' => $subscription->stripe_status,
                    'ends_at' => $subscription->ends_at?->toIso8601String(),
                    'on_grace_period' => $subscription->onGracePeriod(),
                ];
            }
        }

        return response()->json([
            'usage' => $user->getUsageData(),
            'subscription' => $subscriptionData,
        ]);
    }

    public function createCheckoutSession(Request $request): JsonResponse
    {
        $user = $request->user();

        $priceId = config('services.stripe.price_id');

        if (! $priceId) {
            return response()->json([
                'error' => 'Price ID non configuré',
            ], 500);
        }

        try {
            $checkout = $user->newSubscription(User::PLAN_PRO, $priceId)
                ->checkout([
                    'success_url' => config('app.frontend_url').'/subscription/success?session_id={CHECKOUT_SESSION_ID}',
                    'cancel_url' => config('app.frontend_url').'/subscription/cancel',
                ]);

            return response()->json([
                'url' => $checkout->url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de la création de la session de paiement',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function billingPortal(Request $request): JsonResponse
    {
        $user = $request->user();

        try {
            $url = $user->billingPortalUrl(
                config('app.frontend_url').'/dashboard'
            );

            return response()->json([
                'url' => $url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur lors de l\'ouverture du portail',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function cancel(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user->isPro()) {
            return response()->json([
                'error' => 'Aucun abonnement actif',
            ], 400);
        }

        $subscription = $user->subscription(User::PLAN_PRO);

        if ($subscription) {
            $subscription->cancel();

            return response()->json([
                'message' => 'Abonnement annulé avec succès',
                'ends_at' => $subscription->ends_at->toIso8601String(),
            ]);
        }

        return response()->json([
            'error' => 'Abonnement introuvable',
        ], 404);
    }

    public function resume(Request $request): JsonResponse
    {
        $user = $request->user();

        $subscription = $user->subscription(User::PLAN_PRO);

        if (! $subscription || ! $subscription->onGracePeriod()) {
            return response()->json([
                'error' => 'Impossible de réactiver cet abonnement',
            ], 400);
        }

        $subscription->resume();

        return response()->json([
            'message' => 'Abonnement réactivé avec succès',
        ]);
    }
}
