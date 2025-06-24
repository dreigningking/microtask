<div>
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <div class="mobile-sidebar" id="mobileSidebar">
        <div class="p-6">
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('index') }}" class="text-2xl font-['Pacifico'] text-white">
                    <img src="{{asset('frontend/images/logo.png')}}" alt="" style="height:50px;">
                </a>
                <button id="closeSidebar" class="text-white">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>
            <nav class="flex flex-col space-y-4">
                <a wire:navigate href="{{ route('index') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('/')) bg-blue-800 @endif">Home</a>
                <a wire:navigate href="{{ route('explore') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('explore')) bg-blue-800 @endif">Explore</a>
                <a wire:navigate href="{{ route('top_earners') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('top-earners')) bg-blue-800 @endif">Top Earners</a>
                <a wire:navigate href="{{ route('post_job') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('post-job')) bg-blue-800 @endif">Post a Job</a>
                
                @if($isAuthenticated)
                    <a wire:navigate href="{{ route('my_tasks') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('my-tasks')) bg-blue-800 @endif">My Tasks</a>
                    <a wire:navigate href="{{ route('my_jobs') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('my-jobs')) bg-blue-800 @endif">My Jobs</a>
                    <a wire:navigate href="{{ route('dashboard') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('dashboard')) bg-blue-800 @endif">Dashboard</a>
                    <a wire:navigate href="{{ route('my_earnings') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('my-earnings')) bg-blue-800 @endif">Earnings</a>
                    <a wire:navigate href="{{ route('payments') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('payments')) bg-blue-800 @endif">Payments</a>
                    <a wire:navigate href="{{ route('invitees') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('invitees')) bg-blue-800 @endif">Invitees</a>
                    <a wire:navigate href="{{ route('profile') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('profile')) bg-blue-800 @endif">My Profile</a>
                    <a wire:click.prevent="logout" href="#" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded">Sign Out</a>
                @else
                    <a wire:navigate href="{{ route('login') }}" class="text-white py-2 border-b border-blue-700 hover:bg-blue-800 px-2 rounded @if(request()->is('login')) bg-blue-800 @endif">Sign In</a>
                @endif
            </nav>
        </div>
    </div>
</div>