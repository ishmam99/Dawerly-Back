<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Technician;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    private $apiKey;
    private $apiBaseUrl;
    public function __construct()
    {
        $this->apiKey = env('MYFATOORAH_API_KEY');
        $this->apiBaseUrl = "https://api.myfatoorah.com/v2";
    }
    public function initiatePayment(Request $request)
    {
        $apiURL = "https://api.myfatoorah.com/v2/ExecutePayment";
        $apiKey = env('MYFATOORAH_API_KEY'); // Store API Key in .env
        // $apiKey = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL"; // Store API Key in .env

        $data = [
            "PaymentMethodId" => $request->payment_method_id, // Example: 1 for KNET, 2 for Visa/Mastercard
            "InvoiceValue" => $request->amount,
            "Currency" => "KWD",
            "CustomerName" => $request->name,
            "CustomerEmail" => $request->email,
            "CustomerMobile" => auth()->user()->phone,
            "CustomerReference" => auth()->user()->id,
            // "CallBackUrl" => 'http://localhost:5173/success',
            // "ErrorUrl" => 'http://localhost:5173/cancelled',
            "CallBackUrl" => 'https://dawarlykw.net/success',
            "ErrorUrl" => 'https://dawarlykw.net/cancelled',
            "Language" => "en",
        ];

        $response = Http::withHeaders([
            "Authorization" => "Bearer $apiKey",
            "Content-Type" => "application/json"
        ])->post($apiURL, $data);

        return response()->json($response->json());
    }
    public function getPaymentMethods()
    {

        $response = Http::withHeaders([
            "Authorization" => "Bearer $this->apiKey",
            "Content-Type" => "application/json"
        ])->post("$this->apiBaseUrl/InitiatePayment", [
            "InvoiceAmount" => 10,
            "CurrencyIso" => "KWD"
        ]);

        return response()->json($response->json());
    }
    public function paymentCallback(Request $request)
    {
        $apiURL = "https://api.myfatoorah.com/v2/GetPaymentStatus";
        $apiKey = env('MYFATOORAH_API_KEY');
        // $apiKey = "rLtt6JWvbUHDDhsZnfpAhpYk4dxYDQkbcPTyGaKp2TYqQgG7FGZ5Th_WD53Oq8Ebz6A53njUoo1w3pjU1D4vs_ZMqFiz_j0urb_BH9Oq9VZoKFoJEDAbRZepGcQanImyYrry7Kt6MnMdgfG5jn4HngWoRdKduNNyP4kzcp3mRv7x00ahkm9LAK7ZRieg7k1PDAnBIOG3EyVSJ5kK4WLMvYr7sCwHbHcu4A5WwelxYK0GMJy37bNAarSJDFQsJ2ZvJjvMDmfWwDVFEVe_5tOomfVNt6bOg9mexbGjMrnHBnKnZR1vQbBtQieDlQepzTZMuQrSuKn-t5XZM7V6fCW7oP-uXGX-sMOajeX65JOf6XVpk29DP6ro8WTAflCDANC193yof8-f5_EYY-3hXhJj7RBXmizDpneEQDSaSz5sFk0sV5qPcARJ9zGG73vuGFyenjPPmtDtXtpx35A-BVcOSBYVIWe9kndG3nclfefjKEuZ3m4jL9Gg1h2JBvmXSMYiZtp9MR5I6pvbvylU_PP5xJFSjVTIz7IQSjcVGO41npnwIxRXNRxFOdIUHn0tjQ-7LwvEcTXyPsHXcMD8WtgBh-wxR8aKX7WPSsT1O8d8reb2aR7K3rkV3K82K_0OgawImEpwSvp9MNKynEAJQS6ZHe_J_l77652xwPNxMRTMASk1ZsJL";

        $data = [
            "Key" => $request->paymentId, // Get payment ID from URL
            "KeyType" => "paymentId",
        ];

        $response = Http::withHeaders([
            "Authorization" => "Bearer $apiKey",
            "Content-Type" => "application/json"
        ])->post($apiURL, $data);

        $paymentStatus = $response->json();
            \Log::info('Payment Status:', $paymentStatus);
        if ($paymentStatus['IsSuccess']) {
            // Update your order/payment status in DB
            $user = User::find($paymentStatus['Data']['CustomerReference']);
            Payment::create([
                'user_id' => $user->id,
                'amount' => $paymentStatus['Data']['InvoiceValue'],
                'payment_request_id' => $request->paymentId,
                'payment_method' => $paymentStatus['Data']['InvoiceTransactions'][0]['PaymentGateway'],
                'payment_type' => $paymentStatus['Data']['InvoiceTransactions'][0]['PaymentGateway'],
                'payment_status' => $paymentStatus['Data']['InvoiceStatus'],
            ]);
              $technician =  Technician::where('user_id',$user->id)->first();
              $valid_till  =  Carbon::now()->addDays(1);
            if($paymentStatus['Data']['InvoiceValue'] == 15){

                $valid_till  = Carbon::now()->addDays(365);
            }
            else if($paymentStatus['Data']['InvoiceValue'] == 9){
                $valid_till  =  Carbon::now()->addDays(182);
            }
            else if($paymentStatus['Data']['InvoiceValue'] == 5){
                $valid_till  =  Carbon::now()->addDays(90);
            }
            else if($paymentStatus['Data']['InvoiceValue'] == 2){
                $valid_till  =  Carbon::now()->addDays(30);
            }

            // return response()->json($valid_till);
          $technician =  Technician::where('user_id',$user->id)->first();
          $technician->update(['status' => 'active','valid_till'=> $valid_till]);
            return response()->json(['st'=>$paymentStatus,'user' =>  $technician,'sfd'=>$user]);
            return redirect('/payment-success');
        } else {
            return response()->json(['st'=>$paymentStatus]);
            return redirect('/payment-failed');
        }
    }
}
