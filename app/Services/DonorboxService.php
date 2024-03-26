<?php

namespace App\Services;

use App\Enums\DonationType;
use App\Models\Compaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\Plan;
use Illuminate\Support\Facades\Http;

class DonorboxService
{
    public function compaigns()
    {
        $response = $this->request("api/v1/campaigns");
        if ($response->successful()) {
            foreach ($response->json() as $compaign) {
                try {
                    Compaign::updateOrCreate([
                        'id' => $compaign['id']
                    ], [
                        'id' => $compaign['id'],
                        'name' => $compaign['name'],
                        'currency' => $compaign['currency'],
                        'goal_amt' => str_replace('.0', '', $compaign['goal_amt']),
                        'formatted_goal_amount' => $compaign['formatted_goal_amount'],
                        'total_raised' => $compaign['total_raised'],
                        'formatted_total_raised' => $compaign['formatted_total_raised'],
                        'donations_count' => $compaign['donations_count'],
                        'created_at' => $compaign['created_at'],
                        'updated_at' => $compaign['updated_at'],
                    ]);
                } catch (\Throwable $th) {
                    error_log($th->getMessage());
                }
            }

            // Compaign::when('show', false)->whereIn('id', [504654, 511286, 511287, 511291, 511292])->update(['show' => true]);
            return true;
        }

        return false;
    }

    public function donors()
    {
        $response = $this->request("api/v1/donors");
        if ($response->successful()) {
            foreach ($response->json() as $donor) {
                try {
                    Donor::updateOrCreate([
                        'id' => $donor['id']
                    ], [
                        'first_name' => $donor['first_name'],
                        'last_name' => $donor['last_name'],
                        'email' => $donor['email'],
                        'phone' => $donor['phone'],
                        'address' => $donor['address'],
                        'city' => $donor['city'],
                        'state' => $donor['state'],
                        'zip_code' => $donor['zip_code'],
                        'country' => $donor['country'],
                        'comment' => $donor['comment'],
                        'donations_count' => $donor['donations_count'],
                        'last_donation_at' => $donor['last_donation_at'],
                        'total_donation' => collect($donor['total'])->reduce(function (?int $carry, $item) {
                            return $carry + $item['value'];
                        }),
                        'created_at' => $donor['created_at'],
                        'updated_at' => $donor['updated_at'],
                    ]);
                } catch (\Throwable $th) {
                    error_log($th->getMessage());
                }
            }
            return true;
        }

        return false;
    }

    public function donations()
    {
        $response = $this->request("api/v1/donations");
        if ($response->successful()) {
            foreach ($response->json() as $donation) {
                try {
                    Donation::updateOrCreate([
                        'id' => $donation['id']
                    ], [
                        'compaign_id' => $donation['campaign']['id'],
                        'donor_id' => $donation['donor']['id'],
                        'amount' => $donation['amount'],
                        'formatted_amount' => $donation['formatted_amount'],
                        'currency' => $donation['currency'],
                        'type' => isset($donation['stripe_charge_id']) ? DonationType::STRIPE->value : (isset($donation['paypal_transaction_id']) ? DonationType::PAYPAL->value : $donation['donation_type']),
                        'stripe_charge_id' => isset($donation['stripe_charge_id']) ? $donation['stripe_charge_id'] : null,
                        'paypal_transaction_id' => isset($donation['paypal_transaction_id']) ? $donation['paypal_transaction_id'] : null,
                        'status' => $donation['status'],
                        'recurring' => $donation['recurring'],
                        'processing_fee' => $donation['processing_fee'],
                        'formatted_processing_fee' => $donation['formatted_processing_fee'],
                        'donation_date' => $donation['donation_date'],
                        'created_at' => $donation['donation_date'],
                        'updated_at' => $donation['donation_date'],
                        'culacted' => $donation['amount'] - $donation['processing_fee']
                    ]);
                } catch (\Throwable $th) {
                    error_log($th->getMessage());
                }
            }
            return true;
        }

        return false;
    }

    public function plans()
    {
        $response = $this->request("api/v1/plans");
        if ($response->successful()) {
            foreach ($response->json() as $plan) {
                try {
                    Plan::updateOrCreate([
                        'id' => $plan['id']
                    ], [
                        'compaign_id' => $plan['campaign']['id'],
                        'donor_id' => $plan['donor']['id'],
                        'amount' => $plan['amount'],
                        'formatted_amount' => $plan['formatted_amount'],
                        'type' => $plan['type'],
                        'payment_method' => $plan['payment_method'],
                        'status' => $plan['status'],
                        'last_donation_date' => $plan['last_donation_date'],
                        'next_donation_date' => $plan['next_donation_date'],
                        'created_at' => $plan['created_at'],
                        'updated_at' => $plan['updated_at'],
                    ]);
                } catch (\Throwable $th) {
                    error_log($th->getMessage());
                }
            }
            return true;
        }

        return false;
    }

    private function request($url)
    {
        // $url = config('services.donorbox.base_email') . ':' . config('services.donorbox.key') . '@' . config('services.donorbox.base_url') . '/' . $url;
        return Http::withBasicAuth(config('services.donorbox.email'), config('services.donorbox.key'))->get(config('services.donorbox.base_url') . $url);
        // return Http::get($url);
    }
}
