<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class SyncStripeSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stripe:sync-subscriptions {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Synchronize Stripe subscriptions to local database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $email = $this->argument('email');

        if ($email) {
            $users = User::where('email', $email)->get();
        } else {
            $users = User::whereNotNull('stripe_id')->get();
        }

        if ($users->isEmpty()) {
            $this->error('No users found to sync');

            return 1;
        }

        $this->info("Syncing subscriptions for {$users->count()} user(s)...");

        foreach ($users as $user) {
            $this->info("\n--- User: {$user->email} ---");

            if (! $user->stripe_id) {
                $this->warn('No Stripe customer ID, skipping');

                continue;
            }

            $this->info("Stripe Customer: {$user->stripe_id}");

            try {

                $subscriptions = StripeSubscription::all([
                    'customer' => $user->stripe_id,
                    'limit' => 10,
                ]);

                $this->info("Found {$subscriptions->count()} subscription(s) on Stripe");

                foreach ($subscriptions->data as $stripeSub) {
                    $this->line("  → Subscription: {$stripeSub->id} (Status: {$stripeSub->status})");

                    $localSub = $user->subscriptions()->updateOrCreate(
                        ['stripe_id' => $stripeSub->id],
                        [
                            'type' => 'pro',
                            'stripe_status' => $stripeSub->status,
                            'stripe_price' => $stripeSub->items->data[0]->price->id,
                            'quantity' => $stripeSub->items->data[0]->quantity ?? 1,
                            'trial_ends_at' => $stripeSub->trial_end
                                ? Carbon::createFromTimestamp($stripeSub->trial_end)
                                : null,
                            'ends_at' => $stripeSub->ended_at
                                ? Carbon::createFromTimestamp($stripeSub->ended_at)
                                : null,
                        ]
                    );

                    $this->info("  ✓ Synced to local DB (ID: {$localSub->id})");

                    foreach ($stripeSub->items->data as $item) {
                        $localSub->items()->updateOrCreate(
                            ['stripe_id' => $item->id],
                            [
                                'stripe_product' => $item->price->product,
                                'stripe_price' => $item->price->id,
                                'quantity' => $item->quantity ?? 1,
                            ]
                        );
                    }

                    $this->info("  ✓ Synced {$stripeSub->items->count()} item(s)");
                }

                $user->refresh();
                $isPro = $user->isPro();
                $this->info('User is now Pro: '.($isPro ? '✓ YES' : '✗ NO'));

            } catch (\Exception $e) {
                $this->error("Error: {$e->getMessage()}");
            }
        }

        $this->info("\n✓ Sync completed!");

        return 0;
    }
}
