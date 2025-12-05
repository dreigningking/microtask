<div>
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h4 mb-0">Profile Settings</h1>
                    <p class="mb-0">Manage your account information, security, and preferences</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="btn-group">
                        <a href="dashboard.html" class="btn btn-outline-light">Dashboard</a>
                        <a href="earnings.html" class="btn btn-outline-light">Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-4">
        <div class="container">

            <div class="row">
                <!-- Sidebar Navigation -->
                <div class="col-lg-3 mb-4">
                    @include('livewire.settings.menu')
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">           
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-heart-line me-2"></i>Interests
                            </h5>
                        </div>
                        <div class="card-body">
                            <div>
                                @if ($status)
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="ri-check-line me-2"></i>{{ $status }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                @if(count($preferredLocations) > 0 && empty($selected_platforms))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="ri-error-warning-line me-2"></i>
                                    <strong>Heads up!</strong> You've added locations, but you won't receive notifications until you select at least one preferred platform.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @elseif(count($preferredLocations) === 0 && !empty($selected_platforms))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="ri-error-warning-line me-2"></i>
                                    <strong>Almost there!</strong> You've selected platforms, but you won't receive notifications until you add at least one location interest.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                <div class="row">
                                    <!-- Location Interests -->
                                    <div class="col-lg-6 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="ri-map-pin-line me-2"></i>Location Interests
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label for="country" class="form-label">Country</label>
                                                    <select wire:model="selected_country" id="country" class="form-select">
                                                        <option value="">Select a country</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('selected_country') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                                </div>

                                                <button wire:click="addLocation" class="btn btn-primary">
                                                    <i class="ri-add-line me-1"></i>Add Location
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card mt-3">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">Your Saved Locations</h6>
                                            </div>
                                            <div class="card-body">
                                                @forelse($preferredLocations as $location)
                                                <div class="d-flex justify-content-between align-items-center p-2 border rounded mb-2">
                                                    <span class="text-sm">
                                                        <i class="ri-map-pin-line me-1 text-muted"></i>
                                                        {{ $location->country->name }}
                                                    </span>
                                                    <button wire:click="removeLocation({{ $location->id }})" class="btn btn-sm btn-outline-danger">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                                </div>
                                                @empty
                                                <p class="text-muted text-center mb-0">You have no saved locations.</p>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Preferred Platforms -->
                                    <div class="col-lg-6 mb-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="card-title mb-0">
                                                    <i class="ri-apps-line me-2"></i>Preferred Platforms
                                                </h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row g-2">
                                                    @foreach($platforms as $platform)
                                                    <div class="col-md-6">
                                                        <div class="form-check">
                                                            <input type="checkbox" wire:model="selected_platforms"
                                                                value="{{ $platform->id }}"
                                                                class="form-check-input"
                                                                id="platform_{{ $platform->id }}">
                                                            <label class="form-check-label" for="platform_{{ $platform->id }}">
                                                                {{ $platform->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>

                                                <div class="mt-3">
                                                    <button wire:click="savePreferredPlatforms" class="btn btn-primary">
                                                        <i class="ri-save-line me-1"></i>Save Preferred Platforms
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
    </section>
</div>