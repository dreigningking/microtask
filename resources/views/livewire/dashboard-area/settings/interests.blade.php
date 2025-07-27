<div>
    @if ($status)
        <div class="mb-4 text-sm text-green-600 p-4 bg-green-50 dark:bg-green-900/50 rounded-md border border-green-200 dark:border-green-700">
            {{ $status }}
        </div>
    @endif

    @if(count($userLocations) > 0 && empty($selected_platforms))
        <div class="mb-4 p-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
          <span class="font-medium">Heads up!</span> You've added locations, but you won't receive notifications until you select at least one platform interest.
        </div>
    @elseif(count($userLocations) === 0 && !empty($selected_platforms))
        <div class="mb-4 p-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
          <span class="font-medium">Almost there!</span> You've selected platforms, but you won't receive notifications until you add at least one location interest.
        </div>
    @endif
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Location Interests -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Location Interests</h3>
            <div class="space-y-4 p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Country</label>
                        <select wire:model="selected_country" id="country" class="w-full px-4 py-2 border border-gray-300 rounded-button focus:ring-2 focus:ring-primary focus:border-primary outline-none">
                            <option value="">Select a country</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        @error('selected_country') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <button wire:click="addLocation" class="px-4 py-2 bg-primary text-white text-sm font-medium rounded-md">
                    Add Location
                </button>
            </div>

            <div class="mt-6">
                <h4 class="text-md font-semibold text-gray-700 dark:text-gray-300 mb-2">Your Saved Locations</h4>
                <ul class="space-y-2">
                    @forelse($userLocations as $location)
                        <li class="flex justify-between items-center p-3 bg-white dark:bg-gray-600 rounded-md shadow-sm">
                            <span class="text-sm text-gray-800 dark:text-white">
                                {{ $location->country->name }}
                            </span>
                            <button wire:click="removeLocation({{ $location->id }})" class="text-red-500 hover:text-red-700">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </li>
                    @empty
                        <li class="text-sm text-gray-500 dark:text-gray-400">You have no saved locations.</li>
                    @endforelse
                </ul>
            </div>
        </div>
        
        <!-- Platform Interests -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Platform Interests</h3>
            <div class="p-6 bg-gray-50 dark:bg-gray-700 rounded-lg">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($platforms as $platform)
                        <label class="flex items-center space-x-2 text-sm text-gray-700 dark:text-gray-300">
                            <input type="checkbox" wire:model="selected_platforms" value="{{ $platform->id }}" class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50">
                            <span>{{ $platform->name }}</span>
                        </label>
                    @endforeach
                </div>
                <button wire:click="savePlatformInterests" class="mt-6 px-4 py-2 bg-primary text-white text-sm font-medium rounded-md">
                    Save Platform Interests
                </button>
            </div>
        </div>
    </div>
</div>
