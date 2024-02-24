<?php

namespace App\Listeners;

use App\Models\StripePayout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Spatie\WebhookClient\Models\WebhookCall;

class PayoutPaidListener
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
    public function handle(WebhookCall $event)
    {
        if ($event->payload['type'] === 'payout.paid') {
            $payout = $event->payload['data']['object'];
            StripePayout::where('payout_id', $payout['id'])->update([
                'status' => $payout['status'],
                // 'failure_code' => $payout['failure_code'],
                // 'failure_message' => $payout['failure_message'],
            ]);
        }
    }
}
