<section class="hero-section">
    <div class="container">
        <div class="hero-content mx-auto">
            <div class="min-vh-100">
                <div class="card shadow border-0" style="border-radius: 1rem;">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center my-4">
                            <h2 class="fw-bold text-dark mb-2">{{ __('Confirm Password') }}</h2>
                            <p class="text-muted">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
                        </div>
                        <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                            @csrf

                            @if (session('status'))
                            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                                <div class="flex">
                                    <div>
                                        <p class="text-sm text-green-700">{{ session('status') }}</p>
                                    </div>
                                </div>
                            </div>
                            @endif


                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">{{ __('Password') }}</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="ri-lock-line text-gray-400"></i>
                                    </div>
                                    <input type="password" id="password" name="password" class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" required autocomplete="current-password">
                                    <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <i class="ri-eye-off-line text-gray-400" id="passwordEyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                                {{ __('Confirm') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>