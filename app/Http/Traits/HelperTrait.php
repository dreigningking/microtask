<?php
namespace App\Http\Traits;

use App\Models\Role;
use App\Models\User;
use Ixudra\Curl\Facades\Curl;

trait HelperTrait
{
    public function getTimeConversion($minutes){
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $weeks = floor($days / 7);
        $months = floor($days / 30);
        
        if ($minutes < 60) {
            return $minutes . ' mins';
        } elseif ($hours < 24) {
            return $hours . ' hr' . ($hours > 1 ? 's' : '');
        } elseif ($days < 7) {
            return $days . ' day' . ($days > 1 ? 's' : '');
        } elseif ($weeks < 4) {
            return $weeks . ' week' . ($weeks > 1 ? 's' : '');
        } else {
            return $months . ' month' . ($months > 1 ? 's' : '');
        }
    }

    public function getExchangeRate($currency)
    {
        $cacheKey = 'open_exchange_rates';
        $cacheTtl = 60 * 60; // 1 hour in seconds
        $rates = cache($cacheKey);
        if (!$rates || !isset($rates['timestamp']) || (time() - $rates['timestamp']) > $cacheTtl) {
            $appId = config('services.open_exchange');
            if (!$appId) {
                throw new \Exception('Open Exchange Rates App ID not set in .env');
            }
            $url = 'https://openexchangerates.org/api/latest.json?app_id=' . $appId;
            $response = Curl::to($url)->asJson()->get();
            if (!isset($response->rates)) {
                throw new \Exception('Unable to fetch exchange rates from API');
            }
            $rates = [
                'timestamp' => time(),
                'rates' => (array) $response->rates
            ];
            cache([$cacheKey => $rates], now()->addHour());
        }
        if (!isset($rates['rates'][$currency])) {
            throw new \Exception('Unable to fetch exchange rate for ' . $currency);
        }
        return $rates['rates'][$currency];
    }

    public function getMarkedUpRate($currency, $user)
    {
        $baseRate = $this->getExchangeRate($currency);
        $markupPercentage = $user->country->setting->usd_exchange_rate_percentage ?? 0;
        $markup = ($baseRate * $markupPercentage) / 100;
        return $baseRate + $markup;
    }

    public function getAdmin($role_name = null,$country = null)
    {
        $role = Role::where('name',$role_name)->first();
        if($role){
            if($user = User::where('role_id',$role->id)->where('country_id',$country)->first()){
                return $user;
            }
        }
        return User::where('role_id', 1)->first();
    }
}
