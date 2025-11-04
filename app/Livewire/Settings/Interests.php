<?php

namespace App\Livewire\Settings;

use App\Models\Country;
use App\Models\Platform;
use App\Models\PreferredLocation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Interests extends Component
{
    public $countries = [];
    public $platforms = [];
    public $preferredLocations = [];
    public $selected_platforms = [];
    public $selected_country;
    public $status = '';

    public function mount()
    {
        
        $this->countries = Country::all();
        $this->platforms = Platform::all();
        $this->loadUserInterests();
    }

    public function loadUserInterests()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        // 1. Get PreferredLocation models from MySQL
        $preferredLocations = $user->preferred_locations;

        // 2. Get the country IDs
        $countryIds = $preferredLocations->pluck('country_id');

        // 3. Get the Country models from SQLite
        if ($countryIds->isNotEmpty()) {
            $countries = Country::whereIn('id', $countryIds)->get()->keyBy('id');

            // 4. Manually set the 'country' relation on each PreferredLocation model
            $this->preferredLocations = $preferredLocations->each(function ($location) use ($countries) {
                $location->setRelation('country', $countries->get($location->country_id));
            });
        } else {
            $this->preferredLocations = $preferredLocations;
        }
        // Load preferred platforms (this is already a separate query on the correct DB)
        $this->selected_platforms = $user->preferred_platforms()->pluck('platform_id')->toArray();
    }

    public function addLocation()
    {
        $this->validate(['selected_country' => 'required|exists:sqlite_countries.countries,id']);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Prevent duplicates
        if ($user->preferred_locations()->where('country_id', $this->selected_country)->exists()) {
            $this->status = 'You have already added this country.';
            return;
        }

        $user->preferred_locations()->create(['country_id' => $this->selected_country]);
        $this->loadUserInterests();
        $this->status = 'Location added successfully.';
        $this->reset('selected_country');
    }

    public function removeLocation($locationId)
    {
        PreferredLocation::find($locationId)->delete();
        $this->loadUserInterests();
        $this->status = 'Location removed successfully.';
    }

    public function savePreferredPlatforms()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->preferred_platforms()->sync($this->selected_platforms);
        $this->status = 'Preferred platforms saved successfully.';
    }

    public function render()
    {
        return view('livewire.settings.interests');
    }
}
