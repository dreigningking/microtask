<main class="container mx-auto px-4 py-12">
    <div class="max-w-md mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Welcome Back</h1>
                <p class="text-gray-600 mt-2">Sign in to access your account</p>
            </div>

            <form wire:submit="signin" class="space-y-6">
                @csrf

                <div>
                    <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Email or Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-mail-line text-gray-400"></i>
                        </div>
                        <input type="text" id="login" wire:model="login" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" placeholder="your@email.com or username" required>
                    </div>
                    @error('login')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="ri-lock-line text-gray-400"></i>
                        </div>
                        <input type="password" id="password" wire:model="password" class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-button focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary" placeholder="••••••••" required>
                    </div>
                    @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" wire:model="remember" type="checkbox" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>
                    <div>
                        <a wire:navigate href="{{route('password.request')}}" class="text-sm font-medium text-secondary hover:text-primary">Forgot password?</a>
                    </div>
                </div>

                <button type="submit" 
                    class="w-full bg-primary text-white py-2 px-4 rounded-button hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled">
                    <span wire:loading.remove>Sign In</span>
                    <span wire:loading>
                        <i class="ri-loader-4-line animate-spin mr-2"></i>
                        Signing in...
                    </span>
                </button>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Or continue with</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <button type="button" class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-button shadow-sm bg-white hover:bg-gray-50">
                        <i class="ri-google-fill text-lg mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Google</span>
                    </button>
                    <button type="button" class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-button shadow-sm bg-white hover:bg-gray-50">
                        <i class="ri-facebook-fill text-lg mr-2"></i>
                        <span class="text-sm font-medium text-gray-700">Facebook</span>
                    </button>
                </div>
            </div>

            <p class="text-center mt-8 text-sm text-gray-600">
                Don't have an account?
                <a wire:navigate href="{{route('register')}}" class="font-medium text-secondary hover:text-primary">Sign up now</a>
            </p>
        </div>
    </div>
</main>