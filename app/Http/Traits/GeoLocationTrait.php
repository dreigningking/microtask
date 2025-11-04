<?php
namespace App\Http\Traits;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use App\Models\Location;
use Illuminate\Support\Facades\Log;

trait GeoLocationTrait
{


    /*
        +"status": "success"
        +"country": "Nigeria"
        +"countryCode": "NG"
        +"region": "LA"
        +"regionName": "Lagos"
        +"city": "Lagos"
        +"zip": ""
        +"lat": 6.4474
        +"lon": 3.3903
        +"timezone": "Africa/Lagos"
        +"isp": "Globacom Limited"
        +"org": "Glomobile Gprs"
        +"as": "AS328309 Globacom Limited"
        +"query": "197.211.58.12"
    */
    protected function saveLocation($ip, $result){
        try {
			// Validate that we have the required properties from the sample JSON
			if (!$result || !isset($result->countryCode)) {
				Log::warning("Invalid geo result object for IP: {$ip}", ['result' => $result]);
                return;
            }

			$country = $this->getCountry($result->countryCode);
            if (!$country) {
				Log::warning("Country not found for code: {$result->countryCode}");
                return;
            }

			$state = $this->getState($country->id, $result->regionName ?? '', $result->region ?? '');
            
            Location::updateOrCreate([
                'ip' => $ip,
				'continent' => $country->region,
                'country_id' => $country->id,
                'country' => $country->name,
                'code' => $country->iso2,
                'dial' => $country->phonecode,
                'state_id' => $state ? $state->id : null,
                'state' => $state ? $state->name : '',
				'city' => $result->city ?? '',
            ]);
        } catch (\Exception $e) {
            Log::error("Error saving location for IP: {$ip}", [
                'error' => $e->getMessage(),
                'result' => $result
            ]);
        }
    }

    protected function getCountry($code){
        if (!$code) {
            return null;
        }
        $country = Country::where('iso2', $code)->first();
        return $country;
    }

    protected function getState($country_id, $name, $code){
        if (!$country_id) {
            return null;
        }
        
        $state = State::where('country_id', $country_id)->where(function($query) use ($name, $code){
            if ($name) {
                $query->where('name', 'like', '%'.$name.'%');
            }
            if ($code) {
                $query->orWhere('iso2', 'like', '%'.$code.'%');
            }
        })->first();
        return $state;
    }
    
    protected function getLocation(){
        $ip = $this->visitorIp();
        $location = Location::where('ip', $ip)->first();
        if(!$location){
            $location = Location::first();
            Log::info('Fallback to first location', [
                'ip' => $this->visitorIp(),
                'headers' => request()->headers->all()
            ]); 
        }
        return $location;
    }

    protected function visitorIp(){
        $ip = request()->ip();
        
        // Handle Docker internal IPs and localhost
        if ($ip == '::1' || $ip == '127.0.0.1' || $ip == '172.18.0.1' || $ip == '172.17.0.1') {
            // Use a real Nigerian IP for testing in Docker
            return '197.211.58.12';
        }
        
        return $ip;
    }
    
}

