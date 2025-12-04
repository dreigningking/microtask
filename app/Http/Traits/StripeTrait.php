<?php
namespace App\Http\Traits;

use App\Models\User;
use App\Models\Payment;
use App\Models\Profile;
use App\Models\Settlement;
use App\Models\Withdrawal;
use Ixudra\Curl\Facades\Curl;


trait StripeTrait
{

    public function initiateStripe(Payment $payment){
        $items = [];
        $items[] = [  'price_data' => 
                                [ 'currency' => strtolower($payment->currency), 'unit_amount' => $payment->total *100, 
                                'product_data' => [ 'name' => 'Order',  'description' => 'Payment for Task Order','images' => [] ],
                                ], 
                                'quantity' => 1, 
                            ];
        
        $response = Curl::to('https://api.stripe.com/v1/checkout/sessions')
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
            ->withData( array('customer_email' => $payment->user->email,'currency'=> strtolower($payment->currency),
                            'success_url'=> route('payment.callback',with(['tx_ref'=> $payment->reference,'reference'=> $payment->reference,'status'=> 'success'])),
                            'cancel_url'=> route('payment.callback',with(['tx_ref'=> $payment->reference,'reference'=> $payment->reference,'status'=> 'cancelled'])),
                            'client_reference_id'=> uniqid(),'mode'=> 'payment',
                            'line_items' => $items
                            ) )
            ->asJsonResponse()
            ->post();
        if($response && $response->url){
            $payment->request_id = $response->id;
            $payment->save();
            return $response->url;
        }
            
        else return false;
      }
  
      protected function verifyStripePayment($stripe_session_id){
        $response = Curl::to('https://api.stripe.com/v1/checkout/sessions/'.$stripe_session_id)
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
            ->asJsonResponse()
            ->get();
        return $response;
    }
    public function refundStripe(Payment $payment){
        $stripe_session_id = $payment->request_id;
        $session = Curl::to("https://api.stripe.com/v1/checkout/sessions/$stripe_session_id")
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
            ->asJsonResponse()
            ->get();

        $response = Curl::to('https://api.stripe.com/v1/refunds')
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
            ->withData( array('amount'=> $payment->amount * 100,'payment_intent'=> $session->payment_intent ,'reason' => 'requested_by_customer'))
            ->asJsonResponse()
            ->post();
        if($response &&  isset($response->status) && $response->status == "succeeded")
         return true;
         else return false;
    }

    // public function retrieveAccount($bank_details){
    //     $response = Curl::to("https://api.stripe.com/v1/accounts/$bank_details")
    //         ->withHeader('Content-Type: application/x-www-form-urlencoded')
    //         ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
    //         ->asJsonResponse()
    //         ->get();
    //     // acct_1OpTfgGgPcnGNIQ2, acct_1OuekSGazRDBDWQi
    //     
    //     return false;
    // }
  
    public function connectStripe(User $user){
        $response = Curl::to('https://api.stripe.com/v1/accounts')
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
            ->withData( array('type'=> 'express','country'=> $user->country->iso ,'email' => $user->email))
            ->asJsonResponse()
            ->post();
        // acct_1OpTfgGgPcnGNIQ2
        if($response && $response->id){
            $user->bank_details = $response->id;
            $user->save();
            return $response->id;
        }else return false;
    }

    public function accountLink($bank_details){
        $response = Curl::to('https://api.stripe.com/v1/account_links')
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
            ->withData( array('account'=> $bank_details,'type'=> 'account_onboarding',
            'refresh_url'=> route('stripe.onboarding') ,'return_url' => route('stripe.postboarding')))
            ->asJsonResponse()
            ->post();
        if($response && $response->url){
            return $response->url;
        }else return false;
    }

    public function payoutStripe(Settlement $settlement){
        $response = Curl::to('https://api.stripe.com/v1/payouts')
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
            ->withData( array('amount'=> $settlement->amount * 100,'currency'=> $settlement->currency ,'destination'=> $settlement->profile->bank_details))
            ->asJsonResponse()
            ->post();
        if($response && $response->status && $response->status == 'pending'){
            $settlement->transfer_id = $response->id; 
            $settlement->status = 'processing'; 
            $settlement->save();
        }else {
            $settlement->transfer_id = $response->id ?? '';
            $settlement->status = 'failed';
            $settlement->save();
        }
    }

    public function verifyPayoutStripe(Settlement $settlement){
        $response = Curl::to("https://api.stripe.com/v1/payouts/$settlement->transfer_id")
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withHeader('Authorization: Bearer '.config('services.stripe.secret'))
            ->asJsonResponse()
            ->get(); 
            if($response && $response->status && $response->status == 'success'){
                $settlement->status = 'paid';
                $settlement->paid_at = now();
                $settlement->save();
            }
    }


}