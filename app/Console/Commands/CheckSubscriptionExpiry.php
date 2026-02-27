<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckSubscriptionExpiry extends Command
{
    protected $signature   = 'subscriptions:check-expiry';
    protected $description = 'Downgrade expired premium subscriptions to general';

    public function handle()
    {
        $users = User::where('subscription_type', 'premium')->get();

        foreach ($users as $user) {
            $latest = $user->transactions()->where('status', 'completed')->latest()->first();

            if ($latest && $latest->renewal_at <= Carbon::now()) {
                $user->update(['subscription_type' => 'general']);
                $latest->update(['status' => 'expired']);
                $this->info('Downgraded user: ' . $user->email);
            }
        }

        $this->info('Subscription expiry check complete.');
    }
}