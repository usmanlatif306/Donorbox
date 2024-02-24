<?php

namespace App\Listeners;

use App\Models\StripePayout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\WebhookClient\Models\WebhookCall;

class PayoutUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(WebhookCall $event): void
    {
        if ($event->payload['type'] === 'payout.updated') {
            $payout = $event->payload['data']['object'];
            StripePayout::where('payout_id', $payout['id'])->update([
                'failure_message' => $payout['status'],
            ]);
        }
    }
}
