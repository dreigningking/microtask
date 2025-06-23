<header class="bg-primary text-white py-4 px-6 flex items-center justify-between shadow-md sticky top-0 z-50">
    <div class="flex items-center">
        <a href="/" class="text-2xl font-['Pacifico'] text-white">
            <img src="{{asset('frontend/images/logo.png')}}" alt="" style="height:50px;">
        </a>
    </div>
    <div class="hidden md:flex items-center space-x-6">
        <a wire:navigate href="{{ route('index') }}" class="text-white hover:text-gray-200 @if(request()->is('/')) font-semibold border-b-2 border-white @endif">Home</a>
        <a wire:navigate href="{{ route('explore') }}" class="text-white hover:text-gray-200 @if(request()->is('explore')) font-semibold border-b-2 border-white @endif">Explore</a>
        @if($isAuthenticated)
        <a wire:navigate href="{{ route('my_tasks') }}" class="text-white hover:text-gray-200 @if(request()->is('my-tasks')) font-semibold border-b-2 border-white @endif">My Tasks</a>
        <a wire:navigate href="{{ route('my_jobs') }}" class="text-white hover:text-gray-200 @if(request()->is('my-jobs')) font-semibold border-b-2 border-white @endif">My Jobs</a>
        @endif
        
        
        
    </div>
    <div class="flex items-center space-x-4">
        <a wire:navigate href="{{ route('post_job') }}"  class="bg-white text-primary px-4 py-2 rounded-button font-medium hover:bg-gray-100 whitespace-nowrap">Post a Job</a>
        @if($isAuthenticated)
        <div class="relative hidden md:block" id="notificationContainer">
            <button id="notificationButton" class="w-8 h-8 flex items-center justify-center mr-2 relative">
                <i class="ri-notification-3-line text-white text-xl"></i>
                <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">3</span>
            </button>
            <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded shadow-lg py-3 z-10">
                <div class="px-4 py-2 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Notifications</h3>
                </div>
                <!-- Notification 1 -->
                <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-500">
                                <i class="ri-user-add-line"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">New application received</p>
                            <p class="text-xs text-gray-500">John Smith applied to your "Full Stack Developer" job</p>
                            <p class="text-xs text-gray-400 mt-1">10 minutes ago</p>
                        </div>
                    </div>
                </div>
                <!-- Notification 2 -->
                <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center text-green-500">
                                <i class="ri-check-line"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Task completed</p>
                            <p class="text-xs text-gray-500">Amanda Lee completed the "Logo Design" task</p>
                            <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                        </div>
                    </div>
                </div>
                <!-- Notification 3 -->
                <div class="px-4 py-3 hover:bg-gray-50 border-b border-gray-100">
                    <div class="flex">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center text-yellow-500">
                                <i class="ri-money-dollar-circle-line"></i>
                            </div>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Payment processed</p>
                            <p class="text-xs text-gray-500">Your payment of $120 for "Content Writing" has been processed</p>
                            <p class="text-xs text-gray-400 mt-1">Yesterday</p>
                        </div>
                    </div>
                </div>

                <div class="px-4 py-2 text-center">
                    <a wire:navigate href="{{ route('notifications') }}" class="text-primary hover:text-blue-700 text-sm font-medium">View All Notifications</a>
                </div>
            </div>
        </div>
        <!-- Mobile version of notification icon -->
        <div class="w-8 h-8 flex items-center justify-center mr-2 md:hidden relative">
            <i class="ri-notification-3-line text-white text-xl"></i>
            <span class="absolute top-0 right-0 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center text-white text-xs">3</span>
        </div>
        <button class="w-10 h-10 flex items-center justify-center md:hidden" id="mobileMenuButton">
            <i class="ri-menu-line text-white ri-lg"></i>
        </button>
        <div class="relative hidden md:block " id="userMenuContainer" data-navigate-once>
            <button id="userMenuButton" class="w-8 h-8 rounded-full bg-white text-primary flex items-center justify-center">
                <i class="ri-user-line"></i>
            </button>
            <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded shadow-lg py-2 z-10">
                <a wire:navigate href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Dashboard</a>
                <a wire:navigate href="{{ route('my_earnings') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Earnings</a>
                <a wire:navigate href="{{ route('payments') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Payments</a>
                <a wire:navigate href="{{ route('invitees') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Invitees</a>
                <a wire:navigate href="{{ route('profile') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">My Profile</a>
                
                <div class="border-t border-gray-200 my-1"></div>
                <a wire:click.prevent="logout" href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Sign Out</a>
            </div>
        </div>
        @else 
        <a wire:navigate href="{{ route('login') }}" class="bg-white text-primary px-4 py-2 rounded-button font-medium hover:bg-gray-100 whitespace-nowrap">Sign In</a>
        @endif
    </div>
</header>