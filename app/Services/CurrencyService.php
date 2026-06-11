<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    /**
     * Sync exchange rates from the Frankfurter API.
     * Base currency is assumed to be INR.
     *
     * @return array
     */
    public static function syncExchangeRates(): array
    {
        $updated = [];
        $skipped = [];
        $errors = [];

        try {
            // Fetch rates from Frankfurter API with 5-second timeout
            $response = Http::timeout(5)->get('https://api.frankfurter.app/latest', [
                'from' => 'INR'
            ]);

            if (!$response->successful()) {
                throw new \Exception('Failed to fetch rates from Frankfurter API. Status code: ' . $response->status());
            }

            $data = $response->json();
            $rates = $data['rates'] ?? [];

            // Fetch all countries from database to update
            $countries = Country::all();

            foreach ($countries as $country) {
                $currencyCode = strtoupper($country->currency_code);

                // Base currency is always 1.0
                if ($currencyCode === 'INR') {
                    $country->update(['exchange_rate' => 1.0000]);
                    $updated[] = 'INR';
                    continue;
                }

                // If the target currency is supported by Frankfurter, update it
                if (isset($rates[$currencyCode])) {
                    $rate = (float) $rates[$currencyCode];
                    $country->update(['exchange_rate' => $rate]);
                    $updated[] = $currencyCode;
                } else {
                    // Retain existing rate for unsupported currencies (e.g. AED)
                    $skipped[] = $currencyCode;
                }
            }
        } catch (\Exception $e) {
            Log::error('Currency sync failed: ' . $e->getMessage());
            $errors[] = $e->getMessage();
        }

        return [
            'success' => empty($errors),
            'updated' => $updated,
            'skipped' => $skipped,
            'errors' => $errors,
        ];
    }
}
