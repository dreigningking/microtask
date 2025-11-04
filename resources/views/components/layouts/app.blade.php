<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wonegig - Find Your Next Gig</title>

    <link rel="shortcut icon" href="{{asset('frontend/images/favicon1.png')}}" />
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
    <meta name="theme-color" content="#051040">
    <meta name="msapplication-TileColor" content="#051040">
    <meta name="application-name" content="Wonegig">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    <!-- Bootstrap 5 CSS -->
    <link href="{{asset('frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="{{asset('frontend/css/bootstrap-icons.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/theme.css')}}">
    @stack('styles')
</head>

<body>


    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand text-primary pt-0" href="{{ url('/') }}">
                <img src="{{asset('frontend/images/logo2.png')}}" alt="" style="height:30px;">
            </a>
            <!-- mobile notification and toggler -->
            <div class="d-flex d-md-none">
                <div class="dropdown me-3">
                    <a href="#" class="btn btn-outline-primary position-relative" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="notification-badge">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <h6 class="dropdown-header">Notifications</h6>
                        </li>
                        <li><a class="dropdown-item" href="notifications.html">New task matches your skills</a></li>
                        <li><a class="dropdown-item" href="notifications.html">Your withdrawal was processed</a></li>
                        <li><a class="dropdown-item" href="notifications.html">You have a new message</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-center" href="{{ route('notifications') }}">View All</a></li>
                    </ul>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('/')) active @endif" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('explore')) active @endif" href="{{ route('explore') }}">Browse Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('top-earners')) active @endif" href="{{ route('top_earners') }}">Top Earners</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('blog')) active @endif" href="{{ route('blog') }}" href="#">Blog</a>
                    </li>
                    @auth

                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('tasks.posted')) active @endif" href="{{ route('tasks.posted') }}">My Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('tasks.applied')) active @endif" href="{{ route('tasks.applied') }}" href="#">Applied Tasks</a>
                    </li>
                    <!-- Show on mobile -->
                    <div class="d-md-none">
                        <li class="nav-item">
                            <a class="nav-link @if(request()->is('dashboard')) active @endif" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->is('earnings.settlements')) active @endif" href="{{ route('earnings.settlements') }}"><i class="bi bi-wallet2"></i> Earnings</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->is('transactions')) active @endif" href="{{ route('transactions') }}"><i class="bi bi-receipt"></i> Transactions</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->is('invitees')) active @endif" href="{{ route('invitees') }}"><i class="bi bi-people"></i> Invitees</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->is('boosters')) active @endif" href="{{ route('boosters') }}"><i class="bi bi-lightning"></i> Boosters</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link @if(request()->is('support')) active @endif" href="{{ route('support') }}"><i class="bi bi-headset"></i> Support</a>
                        </li>

                        <li class="nav-item"><a class="nav-link @if(request()->is('profile')) active @endif" href="{{ route('profile') }}"><i class="bi bi-star"></i> Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}" wire:click.prevent="logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </div>
                    @endauth
                </ul>
                @guest
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Sign In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                </div>
                @else
                <div class="d-flex">

                    <a href="{{route('tasks.create')}}" class="btn btn-primary me-3"><i class="bi bi-plus-circle"></i> Post a Task</a>
                    <!-- Notifications -->
                    <div class="dropdown me-3 d-none d-md-block">
                        <a href="#" class="btn btn-outline-primary position-relative" data-bs-toggle="dropdown">
                            <i class="bi bi-bell"></i>
                            <span class="notification-badge">3</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <h6 class="dropdown-header">Notifications</h6>
                            </li>
                            <li><a class="dropdown-item" href="notifications.html">New task matches your skills</a></li>
                            <li><a class="dropdown-item" href="notifications.html">Your withdrawal was processed</a></li>
                            <li><a class="dropdown-item" href="notifications.html">You have a new message</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-center" href="{{ route('notifications') }}">View All</a></li>
                        </ul>
                    </div>

                    <!-- Show on Web -->
                    <div class="dropdown d-none d-md-block">
                        <a href="#" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item @if(request()->is('dashboard')) active @endif" href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                            <li><a class="dropdown-item @if(request()->is('tasks.posted')) active @endif" href="{{ route('tasks.posted') }}"><i class="bi bi-briefcase"></i> My Posted Tasks</a></li>
                            <li><a class="dropdown-item @if(request()->is('tasks.applied')) active @endif" href="{{ route('tasks.applied') }}"><i class="bi bi-check-circle"></i> Applied Tasks</a></li>
                            <li><a class="dropdown-item @if(request()->is('earnings.settlements')) active @endif" href="{{ route('earnings.settlements') }}"><i class="bi bi-wallet2"></i> Earnings</a></li>
                            <li><a class="dropdown-item @if(request()->is('transactions')) active @endif" href="{{ route('transactions') }}"><i class="bi bi-receipt"></i> Transactions</a></li>
                            <li><a class="dropdown-item @if(request()->is('invitees')) active @endif" href="{{ route('invitees') }}"><i class="bi bi-people"></i> Invitees</a></li>
                            <li><a class="dropdown-item @if(request()->is('boosters')) active @endif" href="{{ route('boosters') }}"><i class="bi bi-lightning"></i> Boosters</a></li>

                            <li><a class="dropdown-item @if(request()->is('support')) active @endif" href="{{ route('support') }}"><i class="bi bi-headset"></i> Support</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item @if(request()->is('profile')) active @endif" href="{{ route('profile') }}"><i class="bi bi-person-gear"></i> Profile</a></li>
                            <li class="nav-item">
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}" wire:click.prevent="logout"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </div>

                </div>
                @endguest
            </div>
        </div>
    </nav>

    {{ $slot }}


    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 mb-4 mb-lg-0">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{asset('frontend/images/logo.png')}}" alt="" style="height:50px;">
                    </a>
                    <p class="mb-0">+1 (555) 123-4567</p>
                    <p class="text-white">info@wonegig.com</p>
                    <div class="social-icons mt-4">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6>For Workers</h6>
                    <ul class="footer-links">
                        <li><a href="tasks.html">Find Tasks</a></li>
                        <li><a href="#">How it Works</a></li>
                        <li><a href="#">Success Stories</a></li>
                        <li><a wire:navigate href="{{ route('top_earners') }}">Top Earners</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6>For Posters</h6>
                    <ul class="footer-links">
                        <li><a href="#">Post a Task</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Tips</a></li>
                        <li><a href="#">Success Stories</a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4 mb-lg-0">
                    <h6>Company</h6>
                    <ul class="footer-links">
                        <li><a wire:navigate href="{{ route('index') }}">Home</a> </li>
                        <li><a wire:navigate href="{{ route('about') }}">About us</a></li>
                        <li><a wire:navigate href="{{ route('contact') }}">Contact us</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a wire:navigate href="{{ route('blog') }}">Our Blog</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                    <h6>Legal</h6>
                    <ul class="footer-links">
                        <li><a href="{{ route('legal.dcma') }}">DMCA</a></li>
                        <li><a href="{{ route('legal.disclaimer') }}">Disclaimer</a></li>
                        <li> <a href="{{ route('legal.privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('legal.terms-conditions') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('legal.payment-chargeback') }}">Payment & Chargebacks</a></li>
                    </ul>
                </div>
            </div>
            <div class="copyright">
                <p class="mb-0">{{ now()->format('Y') }} Wonegig. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script data-navigate-once src="{{asset('frontend/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    @livewireScripts
    <script>
        $(document).ready(function() {
            Livewire.on('closeModal', function(data) {
                console.log('Close modal event received:', data);
                const modalId = data[0].modalId;

                const modalEl = document.getElementById(modalId);

                // Check if Bootstrap modal instance already exists
                let modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (!modalInstance) {
                    // If not, create a new instance (Bootstrap 5)
                    modalInstance = new bootstrap.Modal(modalEl);
                }
                // Hide the modal with Bootstrap 5 API
                modalInstance.hide();
            });
        });
    </script>
    @stack('scripts')
</body>

</html>