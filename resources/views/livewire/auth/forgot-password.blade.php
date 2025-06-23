<main class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <div class="text-center mb-8">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="ri-lock-unlock-line text-primary text-3xl"></i>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Forgot Your Password?</h1>
                    <p class="text-gray-600 mt-2">Enter your email address and we'll send you a link to reset your password</p>
                </div>
                
                <form wire:submit="sendPasswordResetLink" class="space-y-6">
                    @csrf
                    
                    @if (session('status'))
                        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
                            <div class="flex">
                                <div>
                                    <p class="text-sm text-green-700">{{ session('status') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="ri-mail-line text-gray-400"></i>
                            </div>
                            <input type="email" id="email" wire:model="email" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" placeholder="your@email.com" required>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <button type="submit" 
                        class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                        <span wire:loading.remove>Send Reset Link</span>
                        <span wire:loading>
                            <i class="ri-loader-4-line animate-spin mr-2"></i>
                            Sending...
                        </span>
                    </button>
                </form>
                
                <div class="mt-6 text-center">
                    <a href="{{ route('login') }}" class="inline-flex items-center text-sm font-medium text-secondary hover:text-primary">
                        <i class="ri-arrow-left-line mr-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </main>
