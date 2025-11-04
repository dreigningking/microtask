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
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">Settings Menu</h6>
                            </div>
                            <div class="p-0">
                                <div class="list-group list-group-flush">
                                    <button wire:click="setActiveSection('basic')"
                                        class="list-group-item list-group-item-action d-flex align-items-center {{ $activeSection === 'basic' ? 'active' : '' }}">
                                        <i class="ri-user-line me-3"></i>
                                        <span>Basic Information</span>
                                    </button>
                                    <button wire:click="setActiveSection('bank')"
                                        class="list-group-item list-group-item-action d-flex align-items-center {{ $activeSection === 'bank' ? 'active' : '' }}">
                                        <i class="ri-bank-line me-3"></i>
                                        <span>Bank Accounts</span>
                                    </button>
                                    <button wire:click="setActiveSection('verification')"
                                        class="list-group-item list-group-item-action d-flex align-items-center {{ $activeSection === 'verification' ? 'active' : '' }}">
                                        <i class="ri-shield-check-line me-3"></i>
                                        <span>Verifications</span>
                                    </button>
                                    <button wire:click="setActiveSection('interests')"
                                        class="list-group-item list-group-item-action d-flex align-items-center {{ $activeSection === 'interests' ? 'active' : '' }}">
                                        <i class="ri-heart-line me-3"></i>
                                        <span>Interests</span>
                                    </button>
                                    <button wire:click="setActiveSection('password')"
                                        class="list-group-item list-group-item-action d-flex align-items-center {{ $activeSection === 'password' ? 'active' : '' }}">
                                        <i class="ri-lock-password-line me-3"></i>
                                        <span>Security</span>
                                    </button>
                                    <button wire:click="setActiveSection('notifications')"
                                        class="list-group-item list-group-item-action d-flex align-items-center {{ $activeSection === 'notifications' ? 'active' : '' }}">
                                        <i class="ri-notification-3-line me-3"></i>
                                        <span>Notification Settings</span>
                                    </button>
                                    <button wire:click="setActiveSection('delete')"
                                        class="list-group-item list-group-item-action d-flex align-items-center text-danger {{ $activeSection === 'delete' ? 'active' : '' }}">
                                        <i class="ri-delete-bin-line me-3"></i>
                                        <span>Delete Account</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Main Content -->
                    <div class="col-lg-9">
                        <!-- Basic Information Section -->
                        @if($activeSection === 'basic')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-user-line me-2"></i>Basic Information
                                </h5>
                            </div>
                            <div class="card-body">
                                @livewire('settings.basic-information')
                            </div>
                        </div>
                        @endif

                        <!-- Bank Accounts Section -->
                        @if($activeSection === 'bank')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-bank-line me-2"></i>Bank Accounts
                                </h5>
                            </div>
                            <div class="card-body">
                                @livewire('settings.bank-accounts')
                            </div>
                        </div>
                        @endif

                        <!-- Verifications Section -->
                        @if($activeSection === 'verification')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-shield-check-line me-2"></i>Verifications
                                </h5>
                            </div>
                            <div class="card-body">
                                @livewire('settings.verifications')
                            </div>
                        </div>
                        @endif

                        <!-- Interests Section -->
                        @if($activeSection === 'interests')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-heart-line me-2"></i>Interests
                                </h5>
                            </div>
                            <div class="card-body">
                                @livewire('settings.interests')
                            </div>
                        </div>
                        @endif

                        <!-- Security Section -->
                        @if($activeSection === 'password')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-lock-password-line me-2"></i>Security
                                </h5>
                            </div>
                            <div class="card-body">
                                @livewire('settings.security')
                            </div>
                        </div>
                        @endif

                        <!-- Notification Settings Section -->
                        @if($activeSection === 'notifications')
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-notification-3-line me-2"></i>Notification Settings
                                </h5>
                            </div>
                            <div class="card-body">
                                @livewire('settings.notification-settings')
                            </div>
                        </div>
                        @endif

                        <!-- Delete Account Section -->
                        @if($activeSection === 'delete')
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title mb-0">
                                    <i class="ri-delete-bin-line me-2"></i>Delete Account
                                </h5>
                            </div>
                            <div class="card-body">
                                @livewire('settings.delete-account')
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
        </div>
    </section>
</div>
