<?php
namespace App\Http\Traits;

use App\Models\Payout;
use App\Models\Payment;
use Ixudra\Curl\Facades\Curl;


trait StripeTrait
{

  protected function get_token(){
      $id = base64_encode(config('services.paypal.client'));
      $secret = base64_encode(config('services.paypal.secret'));
      $response = Curl::to('https://api-m.sandbox.paypal.com/v1/oauth2/token')
          ->withHeader("Authorization: Basic ".$id.":".$secret)
          ->withHeader('Content-Type: application/x-www-form-urlencoded')
          ->withData(["grant_type"=>"client_credentials"])
          ->asJsonResponse()
          ->post();
      if($response && $response->access_token)
      return $response->access_token;
      else return false;
  }

  protected function initiateStripe(Payment $payment){
      $user = auth()->user();
      $token = config('services.paypal.token');
      // $token = $this->get_token();
      if(!$token){
          return "Something is wrong, please contact the admin";
      }
      // dd($token);
      $response = Curl::to(config('services.paypal.url')."/checkout/orders")
          ->withHeader('Authorization: Bearer '.$token)
          ->withHeader('PayPal-Request-Id: '.uniqid())
          ->withData([
              "intent" => "CAPTURE",
              "purchase_units" => [
                  [
                      "items" => [
                          [
                              "name" => "Payment on Wonegig",
                              "description" => "Payment for ".($user->role->name == 'shopper' ? 'Orders':'Subscription/Adverts'),
                              "quantity" => "1",
                              "unit_amount" => [
                                  "currency_code" => $payment->currency->code,
                                  "value" => $payment->amount,
                              ],
                          ],
                      ],
                      "amount" => [
                          "currency_code" => $payment->currency->code,
                          "value" => $payment->amount,
                          "breakdown" => [
                              "item_total" => [
                                  "currency_code" => $payment->currency->code,
                                  "value" => $payment->amount,
                              ],
                          ],
                      ],
                  ],
              ],
              "application_context" => [
                  "return_url" => route('home'),
                  "cancel_url" => route('home'),
              ],
          ])
          ->asJson()
          ->post();
      //dd($response);
      if($response && $response->status == 'CREATED' && $response->links[1]->href){
          return redirect()->to($response->links[1]->href);
      }
      
  }


    

    protected function verifyPapalPayment($value){
        $paymentDetails = Curl::to('https://api.paystack.co/transaction/verify/'.$value)
         ->withHeader('Authorization: Bearer '.config('services.paystack.secret'))
         ->asJson()
         ->get();
        return $paymentDetails;
    }

    

    protected function payoutPaypal(Payout $payout){
        $response = Curl::to('https://api.paystack.co/transfer')
        ->withHeader('Authorization: Bearer '.config('services.paystack.secret'))
        ->withHeader('Content-Type: application/json')
        ->withData( array("source" => "balance", "reason"=> "Withdrawal Payout", "amount"=> $payout->amount * 100, "recipient"=> $payout->user->payout_account,
        "currency"=> $payout->currency->code,"reference"=> $payout->reference ) )
        ->asJson()                
        ->post();
        //dd($response);
        if($response &&  isset($response->status) && $response->status)
          return true;
        else return false;
    }

    protected function verifyPayoutPaypal(Payout $payout){
      $response = Curl::to("https://api.paystack.co/transfer/verify/$payout->reference")
          ->withHeader('Authorization: Bearer '.config('services.paystack.secret'))
          ->asJson()
          ->get();
      //check the status and update
  }
    
    

    protected function retryPaypal(Payout $payout){
        $response = Curl::to("https://api.paystack.com/v3/transfers/$payout->transfer_id/retries")
            ->withHeader('Authorization: Bearer '.config('services.flutter.secret'))
            ->asJson()
            ->get();
        //check the status and update
    }


}