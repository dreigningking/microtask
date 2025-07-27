<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('frontend/images/favicon1.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('frontend/images/favicon1.png') }}">
    
    <title>{{ $title ?? 'Wonegig - Micro-Jobs Platform | Earn Money Online' }}</title>
    <meta name="title" content="{{$meta_title ?? 'Wonegig - Micro-Jobs Platform | Earn Money Online'}}">
    <meta name="description" content="{{ $metaDescription ?? 'Wonegig is a leading micro-jobs platform connecting freelancers with quick tasks and earning opportunities. Post jobs, complete tasks, and earn money online. Join thousands of users worldwide'}}">
    <meta name="keywords" content="{{ $meta_keywords ?? 'micro jobs, freelance, online work, earn money online, remote work, quick tasks, freelancing platform, work from home'}}">
    <meta name="author" content="Wonegig">
    <meta name="robots" content="index, follow">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $og_title ?? 'Wonegig - Micro-Jobs Platform | Earn Money Online'}}">
    <meta property="og:description" content="{{ $og_description ?? 'Connect with thousands of micro-jobs and start earning today. Wonegig is the premier platform for quick tasks, freelance work, and online earning opportunities. Join our community of freelancers and clients worldwide.'}}">
    <meta property="og:image" content="{{$og_image ?? asset('frontend/images/og-image.png')}}">
    <meta property="og:site_name" content="Wonegig">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{$twitter_title ?? 'Wonegig - Micro-Jobs Platform | Earn Money Online'}}">
    <meta property="twitter:description" content="{{$twitter_description ?? 'Connect with thousands of micro-jobs and start earning today. Wonegig is the premier platform for quick tasks, freelance work, and online earning opportunities.'}}">
    <meta property="twitter:image" content="{{ $twitter_image ?? asset('frontend/images/og-image.png')}}">
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#1e3a8a">
    <meta name="msapplication-TileColor" content="#1e3a8a">
    <meta name="application-name" content="Wonegig">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Preconnect for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdn.tailwindcss.com">
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    
    <!-- Stylesheets -->
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/css/theme.css') }}">
    
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
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
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div>
                    <a href="{{route('index')}}" class="text-2xl font-['Pacifico'] text-white mb-4 inline-block">
                        <img src="{{asset('frontend/images/logo.png')}}" alt="" style="height:50px;">
                    </a>
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
                
                <div class="grid grid-cols-2 gap-4 ">
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                        <ul class="space-y-2">
                            <li><a wire:navigate href="{{ route('index') }}" class="text-gray-300 hover:text-white">Home</a></li>
                            
                            <li><a href="{{ route('blog') }}" class="text-gray-300 hover:text-white">Our Blog</a></li>
                            <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-white">About us</a></li>
                            <li><a href="{{ route('contact') }}" class="text-gray-300 hover:text-white">Contact us</a></li>
                            <li><a wire:navigate href="{{ route('top_earners') }}" class="text-gray-300 hover:text-white">Top Earners</a></li>
                        </ul>
                    </div>
                    
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Resources</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('legal.dcma') }}" class="text-gray-300 hover:text-white">DMCA</a></li>
                            <li><a href="{{ route('legal.disclaimer') }}" class="text-gray-300 hover:text-white">Disclaimer</a></li>
                            <li><a href="{{ route('legal.privacy-policy') }}" class="text-gray-300 hover:text-white">Privacy Policy</a></li>
                            <li><a href="{{ route('legal.terms-conditions') }}" class="text-gray-300 hover:text-white">Terms & Conditions</a></li>
                            <li><a href="{{ route('legal.payment-chargeback') }}" class="text-gray-300 hover:text-white">Payment & Chargebacks</a></li>
                        </ul>
                    </div>
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
            
            <div class="border-t border-white/20 mt-8 pt-8 flex justify-center items-center">
                <p class="text-gray-300 text-sm">© 2025 Copyright. All rights reserved.</p>
            </div>
        </div>
    </footer>
    @livewireScripts
    
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/theme.js') }}"></script>
    @stack('scripts')
</body>
</html>
