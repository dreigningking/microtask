<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wonegig - Home</title>
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/theme.css') }}">
    
    <script>tailwind.config={theme:{extend:{colors:{primary:'#1e3a8a',secondary:'#3b82f6'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Mobile Sidebar -->
    @livewire('layouts.menu-mobile')

    <!-- Header -->
    @livewire('layouts.menu-desktop')

    <!-- Main Content -->
    {{ $slot }}

    <!-- Footer -->
    <footer class="bg-primary text-white mt-12">
        <div class="container mx-auto px-4 py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div>
                    <a href="/" class="text-2xl font-['Pacifico'] text-white mb-4 inline-block">logo</a>
                    <p class="text-gray-300 mb-4">Connect with thousands of micro-jobs you can start completing today. Register now to earn money from your skills.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30">
                            <i class="ri-facebook-fill text-white"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30">
                            <i class="ri-twitter-fill text-white"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30">
                            <i class="ri-instagram-fill text-white"></i>
                        </a>
                        <a href="#" class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30">
                            <i class="ri-linkedin-fill text-white"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a wire:navigate href="{{ route('index') }}" class="text-gray-300 hover:text-white">Home</a></li>
    
                        <li><a wire:navigate href="{{ route('top_earners') }}" class="text-gray-300 hover:text-white">Top Earners</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Post a Job</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">How It Works</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Pricing</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-300 hover:text-white">Help Center</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Blog</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Community</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Success Stories</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">FAQ</a></li>
                    </ul>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold mb-4">Subscribe</h3>
                    <p class="text-gray-300 mb-4">Get the latest jobs and updates delivered to your inbox.</p>
                    <form class="flex flex-col space-y-2">
                        <input type="email" placeholder="Your email address" class="px-4 py-2 rounded-button text-gray-800 border-none focus:outline-none focus:ring-2 focus:ring-white">
                        <button type="submit" class="bg-white text-primary px-4 py-2 rounded-button hover:bg-gray-100 whitespace-nowrap">Subscribe</button>
                    </form>
                </div>
            </div>
            
            <div class="border-t border-white/20 mt-8 pt-8 flex flex-col md:flex-row justify-between items-center">
                <p class="text-gray-300 text-sm mb-4 md:mb-0">© 2025 logo. All rights reserved.</p>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-300 hover:text-white text-sm">Terms of Service</a>
                    <a href="#" class="text-gray-300 hover:text-white text-sm">Privacy Policy</a>
                    <a href="#" class="text-gray-300 hover:text-white text-sm">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>
    @livewireScripts
    
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/theme.js') }}"></script>
    @stack('scripts')
</body>
</html>
