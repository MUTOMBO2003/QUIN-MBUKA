<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CinetpayService
{
    public static function verifierStatutPaiement($transaction_id)
    {
        $api_key = env('CINETPAY_API_KEY');
        $site_id = env('CINETPAY_SITE_ID');
        $url = "https://api-checkout.cinetpay.com/v2/payment/check";

        try {
            $response = Http::post($url, [
                'transaction_id' => $transaction_id,
                'apikey' => $api_key,
                'site_id' => $site_id,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return $data['data']['status'] ?? 'inconnu';
            }

            return 'invalide';
        } catch (\Exception $e) {
            return 'erreur';
        }
    }
}
