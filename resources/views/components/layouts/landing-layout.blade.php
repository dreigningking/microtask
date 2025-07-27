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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Design System Variables -->
    <link rel="stylesheet" href="{{asset('frontend/css/variables.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/landing.css')}}">
    @livewireStyles
    @stack('styles')
    
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{asset('frontend/images/logo2.png')}}" alt="" style="height:50px;">
                <!-- <h2 class="fw-bold text-primary">Wone<span class="text-secondary">gig</span></h2> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('/')) active @endif" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('explore')) active @endif" href="{{ route('explore') }}">Explore Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(request()->is('creators')) active @endif" href="{{ route('creators') }}">For Creators</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">Resources</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About</a>
                    </li>
                </ul>
                <div class="d-flex">
                    @guest
                    <a href="#" class="btn btn-outline-primary me-2 pt-2">Log In</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Sign Up</a>
                    @else
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Dashboard</a>
                    @endguest

                </div>
            </div>
        </div>
    </nav>

    
    {{ $slot }}

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h3 class="footer-title">Wonegig</h3>
                    <p>Connecting talented professionals with businesses looking for top talent. Find your perfect gig opportunity today.</p>
                    <div class="mt-4">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="footer-title">Quick Links</h5>
                    <div class="footer-links">
                        <a wire:navigate href="{{ route('index') }}" >Home</a>  
                        <a wire:navigate href="{{ route('blog') }}" >Our Blog</a>
                        <a wire:navigate href="{{ route('about') }}" >About us</a>
                        <a wire:navigate href="{{ route('contact') }}" >Contact us</a>
                        <a wire:navigate href="{{ route('top_earners') }}" >Top Earners</a>
                        
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5 class="footer-title">Policies</h5>
                    <div class="footer-links">
                        <a href="{{ route('legal.dcma') }}" >DMCA</a>
                        <a href="{{ route('legal.disclaimer') }}" >Disclaimer</a>
                        <a href="{{ route('legal.privacy-policy') }}" >Privacy Policy</a>
                        <a href="{{ route('legal.terms-conditions') }}" >Terms & Conditions</a>
                        <a href="{{ route('legal.payment-chargeback') }}" >Payment & Chargebacks</a>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-4 mb-4">
                    <h5 class="footer-title">Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Remote Lane, Innovation City, USA</li>
                        <li class="mb-2"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i> info@wonegig.com</li>
                    </ul>
                    <div class="mt-3">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your Email">
                            <button class="btn btn-primary" type="button">Subscribe</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="copyright">
                        <p>{{ now()->format('Y') }} Wonegig. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script data-navigate-once src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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