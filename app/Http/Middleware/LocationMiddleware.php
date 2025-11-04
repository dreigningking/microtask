<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;
use App\Models\CountrySetting;
use App\Http\Traits\GeoLocationTrait;

class LocationMiddleware
{
    use GeoLocationTrait;
    
    public function handle(Request $request, Closure $next)
    {
        //178.238.11.6 || 197.211.58.12

        $ip = $this->visitorIp();
        if(!cache('visitors') || cache('visitors') == null || cache('visitors') == [] || !in_array($ip,cache('visitors'))){
            $result = Curl::to("http://ip-api.com/json/" . $ip)->asJsonResponse()->get();  
            if(!$result || $result->status == 'fail'){
                $visitors = array_filter(cache('visitors',[]), function($item) use ($ip) {
                    return $item !== $ip;
                });
                cache(['visitors'=> $visitors]);
                abort(503,'Could not identify your location');
            }
            $country = $this->getCountry($result->countryCode);
            if(!$country){
                abort(503, 'Service unavailable in your country.');
            } 
            $hasSetting = CountrySetting::where('country_id', $country->id)->exists();
            if(!$hasSetting){
                abort(503, 'Service unavailable in your country.');
            }
            $this->saveLocation($ip,$result);
            $visitors[] = $ip;
            cache(['visitors'=> $visitors]);
            
        }
        return $next($request);
    }
}
