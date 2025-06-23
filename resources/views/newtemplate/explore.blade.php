<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Jobs - Find Quick Tasks & Earn Money</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <script src="https://cdn.tailwindcss.com/3.4.16"></script>
    <script>tailwind.config={theme:{extend:{colors:{primary:'#1e3a8a',secondary:'#3b82f6'},borderRadius:{'none':'0px','sm':'4px',DEFAULT:'8px','md':'12px','lg':'16px','xl':'20px','2xl':'24px','3xl':'32px','full':'9999px','button':'8px'}}}}</script>
    <script src="{{ asset('js/theme.js') }}"></script>
</head>
<body class="bg-gray-50">
    <!-- Mobile Sidebar -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="p-6">
            <div class="flex justify-between items-center mb-8">
                <a href="/" class="text-2xl font-['Pacifico'] text-white">logo</a>
                <button id="closeSidebar" class="text-white">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            <nav class="flex flex-col space-y-4">
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">Home</a>
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">Explore</a>
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">Top Earners</a>
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">Post a Job</a>
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">My Jobs</a>
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">Tasks</a>
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">Earnings</a>
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">My Profile</a>
                <a href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">Sign Out</a>
            </nav>
        </div>
    </div>

    <!-- Header -->
    <header class="bg-primary text-white py-4 px-6 flex items-center justify-between shadow-md sticky top-0 z-50">
        <div class="flex items-center">
            <a href="/" class="text-2xl font-['Pacifico'] text-white">logo</a>
        </div>
        <div class="hidden md:flex items-center space-x-6">
            <a href="#" class="text-white hover:text-gray-200">Home</a>
            <a href="#" class="text-white hover:text-gray-200 font-semibold border-b-2 border-white">Explore</a>
            <a href="#" class="text-white hover:text-gray-200">Top Earners</a>
            <a href="#" class="text-white hover:text-gray-200">Post a Job</a>
        </div>
        <div class="flex items-center space-x-4">
            <button class="bg-white text-primary px-4 py-2 rounded-button font-medium hover:bg-gray-100 whitespace-nowrap md:hidden">Sign In</button>
            <div class="w-8 h-8 flex items-center justify-center mr-2">
                <i class="ri-notification-3-line text-white text-xl"></i>
            </div>
            <button class="w-10 h-10 flex items-center justify-center md:hidden" id="mobileMenuButton">
                <i class="ri-menu-line text-white ri-lg"></i>
            </button>
            <div class="relative hidden md:block" id="userMenuContainer">
                <button id="userMenuButton" class="w-8 h-8 rounded-full bg-white text-primary flex items-center justify-center">
                <i class="ri-user-line"></i>
                </button>
                <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded shadow-lg py-2 z-10">
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">My Profile</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">My Jobs</a>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Settings</a>
                    <div class="border-t border-gray-200 my-1"></div>
                    <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Sign Out</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    

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
                        <li><a href="#" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="#" class="text-gray-300 hover:text-white">Explore Jobs</a></li>
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

    <!-- Job Details Modal (Hidden by default) -->
    
</body>
</html>