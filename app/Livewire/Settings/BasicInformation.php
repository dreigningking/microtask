<?php

namespace App\Livewire\Settings;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class BasicInformation extends Component
{
    public $name;
    public $phone;
    public $country_id;
    public $state_id;
    public $city_id;
    public $address;
    public $dob;
    public $gender;

    public $countries = [];
    public $states = [];
    public $cities = [];

    public function mount()
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone;
        $this->country_id = $user->country_id;
        $this->state_id = $user->state_id;
        $this->city_id = $user->city_id;
        $this->address = $user->address;
        $this->dob = $user->dob;
        $this->gender = $user->gender;

        $this->countries = Country::all();
        if ($this->country_id) {
            $this->states = State::where('country_id', $this->country_id)->get();
        }
        if ($this->state_id) {
            $this->cities = City::where('state_id', $this->state_id)->get();
        }
    }

    public function updatedCountryId($value)
    {
        $this->states = State::where('country_id', $value)->get();
        $this->state_id = null;
        $this->cities = [];
        $this->city_id = null;
    }

    public function updatedStateId($value)
    {
        $this->cities = City::where('state_id', $value)->get();
        $this->city_id = null;
    }

    public function updateBasicInformation()
    {
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country_id' => 'required|exists:sqlite_countries.countries,id',
            'state_id' => 'required|exists:sqlite_states.states,id',
            'city_id' => 'required|exists:sqlite_cities.cities,id',
            'address' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->update($validated);

        $this->dispatch('profile-updated', name: $user->name);
        session()->flash('status', 'profile-updated');
    }

    public function render()
    {
        return view('livewire.settings.basic-information');
    }
}
