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
                    <!-- Basic Information Section -->
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="ri-user-line me-2"></i>Basic Information
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="p-6">
                                <form wire:submit.prevent="updateBasicInformation">
                                    <div class="row g-3">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Full Name</label>
                                            <input type="text" id="name" wire:model="name" class="form-control">
                                            @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Phone -->
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="tel" id="phone" wire:model="phone" class="form-control">
                                            @error('phone') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Country -->
                                        <div class="col-md-6">
                                            <label for="country" class="form-label">Country</label>
                                            <select id="country" wire:model="country_id" class="form-select" disabled>
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- State -->
                                        <div class="col-md-6">
                                            <label for="state" class="form-label">State</label>
                                            <select id="state" wire:model.live="state_id" class="form-select" @if(empty($states)) disabled @endif>
                                                <option value="">Select a state</option>
                                                @foreach($states as $state)
                                                <option value="{{ $state->id }}">{{ $state->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('state_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- City -->
                                        <div class="col-md-6">
                                            <label for="city" class="form-label">City</label>
                                            <select id="city" wire:model="city_id" class="form-select" @if(empty($cities)) disabled @endif>
                                                <option value="">Select a city</option>
                                                @foreach($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('city_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Address -->
                                        <div class="col-md-6">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" id="address" wire:model="address" class="form-control">
                                            @error('address') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Date of Birth -->
                                        <div class="col-md-6">
                                            <label for="dob" class="form-label">Date of Birth</label>
                                            <input type="date" id="dob" wire:model="dob" class="form-control">
                                            @error('dob') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <!-- Gender -->
                                        <div class="col-md-6">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select id="gender" wire:model="gender" class="form-select">
                                                <option value="">Select gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="other">Other</option>
                                            </select>
                                            @error('gender') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="mt-4 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="ri-save-line me-1"></i>Save Changes
                                        </button>
                                    </div>

                                    @if (session('status') === 'profile-updated')
                                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                        <i class="ri-check-line me-2"></i>Profile updated successfully!
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>

                   
                </div>
            </div>
        </div>
    </section>
</div>