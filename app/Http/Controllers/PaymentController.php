<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Square\SquareClient;
use Square\Environment;
use Square\Models\Money;
use Square\Models\CreatePaymentRequest;

class PaymentController extends Controller
{
    public function index()
    {
        //dd(1);
        return view('payment');
    }

    public function createPayment(Request $request)
    {
        $square = new SquareClient([
            'environment' => Environment::PRODUCTION, // or Environment::SANDBOX for testing
            'access_token' => config('app.square_access_token'),
        ]);

        $locationId = config('app.square_location_id');
        $currency = 'USD';

        $requestParams = [
            'source_id' => $request->input('nonce'),
            'amount_money' => new Money([
                'amount' => $request->input('amount'), // Amount in cents
                'currency' => $currency,
            ]),
        ];

        $createPaymentRequest = new CreatePaymentRequest($locationId, uniqid(), $requestParams);

        try {
            $response = $square->paymentsApi->createPayment($createPaymentRequest);

            // Handle success
            return response()->json($response, 200);
        } catch (\Square\Square\Exceptions\ApiException $e) {
            // Handle error
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
