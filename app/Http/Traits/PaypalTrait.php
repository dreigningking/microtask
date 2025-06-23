<?php
namespace App\Http\Traits;

use App\Models\Payout;
use App\Models\Payment;
use App\Models\Settlement;
use Ixudra\Curl\Facades\Curl;


trait PaypalTrait
{

    protected function get_token(){
        $client = base64_encode(config('services.paypal.client'));
        $secret = base64_encode(config('services.paypal.secret'));
        $response = Curl::to('https://api-m.sandbox.paypal.com/v1/oauth2/token')
            ->withHeader("Authorization: Basic ".$client.":".$secret)
            ->withHeader('Content-Type: application/x-www-form-urlencoded')
            ->withData(["grant_type"=>"client_credentials"])
            ->asJsonResponse()
            ->post();
        if($response && $response->access_token){
            cache(['paypal_token' => $response->access_token],now()->addHours($response->expires_in / 3600));
            return true;
        }
        return false;
    }

    protected function initiatePaypal(Payment $payment){
        $user = $payment->user;
        $token = cache('paypal_token');
        if(!$token){
            $token = $this->get_token();
        }
        $response = Curl::to("https://api-m.sandbox.paypal.com/v2/checkout/orders")
            ->withHeader('Authorization: Bearer '.$token)
            ->withHeader('PayPal-Request-Id: '.$payment->reference)
            ->withData([
                "intent" => "CAPTURE",
                "purchase_units" => [
                    [
                        "items" => [
                            [
                                "name" => "Payment on Expiringsoon",
                                "description" => "Payment for ".($user->role->name == 'shopper' ? 'Orders':'Subscription/Adverts'),
                                "quantity" => "1",
                                "unit_amount" => [
                                    "currency_code" => $payment->currency->iso,
                                    "value" => $payment->amount,
                                ],
                            ],
                        ],
                        "amount" => [
                            "currency_code" => $payment->currency->iso,
                            "value" => $payment->amount,
                            "breakdown" => [
                                "item_total" => [
                                    "currency_code" => $payment->currency->iso,
                                    "value" => $payment->amount,
                                ],
                            ],
                        ],
                    ],
                ],
                "application_context" => [
                    "return_url" => route('payment.callback').'?status=success&reference='.$payment->reference,
                    "cancel_url" => route('home').'?status=cancelled&reference='.$payment->reference,
                ],
            ])
            ->asJson()
            ->post();
            // dd($response);
            if($response && $response->status == 'CREATED' && $response->links[1]->href){
                $link = $response->links[1]->href;
                $ref = $response->id;
                return ['link'=> $link,'reference'=> $ref];
            }
            else
            return redirect()->route('home')->with(['result'=> 0,'message'=> 'Something went wrong']);
      
    }  

    protected function verifyPaypalPayment($reference,$request_id){
        $token = cache('paypal_token');
        if(!$token){
            $token = $this->get_token();
        }
        $paymentDetails = Curl::to("https://api-m.sandbox.paypal.com/v2/checkout/orders/$reference/capture")
            ->withHeader('Content-Type: application/json')
            ->withHeader('Authorization: Bearer '.$token)
            ->withHeader('PayPal-Request-Id: '.$request_id)
            ->asJsonResponse()
            ->post();
        //  dd($paymentDetails);
        return $paymentDetails;
    }

    protected function refundPaypal(Settlement $settlement){
        $token = cache('paypal_token');
        if(!$token){
            $token = $this->get_token();
        }
        $payment = $settlement->order->payment_item->payment;
        $payment->request_id = uniqid();
        $payment->save();
        $reference = $payment->reference;
        $response = Curl::to("https://api-m.sandbox.paypal.com/v2/payments/captures/$reference/refund")
            ->withHeader('Content-Type: application/json')
            ->withHeader('Authorization: Bearer '.$token)
            ->withHeader('PayPal-Request-Id: '.$payment->request_id)
            ->withData( array('transaction'=> $settlement->order->payment_item->payment->reference,'amount'=> $settlement->amount ) )
            ->withData([
                    "amount"=> [ "value"=> $settlement->amount, "currency_code"=> $settlement->order->payment_item->payment->currency->iso],
                    "invoice_id"=> $settlement->order->id,
                    "note_to_payer"=> "Order Cancelled"
            ])
            ->asJson()
            ->post();
        if($response &&  isset($response->status) && $response->status == 'COMPLETED')
        return true;
        else return false;
    }
    

    protected function payoutPaypal(Payout $payout){
        $token = cache('paypal_token');
        if(!$token){
            $token = $this->get_token();
        }
        $response = Curl::to('https://api-m.sandbox.paypal.com/v1/payments/payouts')
        ->withHeader('Authorization: Bearer '.$token)
        ->withHeader('Content-Type: application/json')
        ->withData( 
            [
                'sender_batch_header'=> [
                    "sender_batch_id"=> 'Payoutz_'.$payout->reference,
                    "email_subject"=> "You have a payout!",
                    "email_message"=> "You have received a withdrawal payout! Thanks for using our service!"
                ],
                "items"=> [
                    [
                      "recipient_type"=> "EMAIL",
                      "amount"=> [
                        "value"=> $payout->amount,
                        "currency"=> $payout->currency->iso
                      ],
                      "note"=> "Thanks for your patronage!",
                      "sender_item_id"=> $payout->reference,
                      "receiver"=> $payout->user->payout_account,
                    ]
                  ]
            ])
        ->asJson()                
        ->post();
        if($response &&  isset($response->batch_header)){
            $payout->transfer_id = $response->batch_header->payout_batch_id;
            $payout->save();
            return true;
        }
        return false;
    }

    protected function verifyPayoutPaypal(Payout $payout){
      $response = Curl::to("https://api.paystack.co/transfer/verify/$payout->reference")
          ->withHeader('Authorization: Bearer '.config('services.paystack.secret'))
          ->asJson()
          ->get();
      //check the status and save status
  }
    
    

    protected function retryPayoutPaypal(Payout $payout){
        $response = Curl::to("https://api.paystack.com/v3/transfers/$payout->transfer_id/retries")
            ->withHeader('Authorization: Bearer '.config('services.flutter.secret'))
            ->asJson()
            ->get();
        //check the status and update
    }


}