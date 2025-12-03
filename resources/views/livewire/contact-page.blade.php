<div>
    <!-- Hero Section -->
    <section class="contact-hero-bg py-5 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="display-5 fw-bold mb-3">Contact Us</h1>
                    <p class="lead mb-0">Have a question, need support, or want to partner with Wonegig? Our team is here to help you succeed.</p>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end">
                    <nav class="mt-2 mt-md-0" aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-light">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-white-50">Home</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Section -->
    <section class="py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Information -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body p-4">
                            <h2 class="h4 fw-bold text-primary mb-4">Get in Touch</h2>

                            <!-- Email -->
                            <div class="d-flex mb-4">
                                <div class="contact-info-icon me-3">
                                    <i class="bi bi-envelope-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-1">Email</h5>
                                    <p class="text-muted small mb-0">support@wonegig.com</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="d-flex mb-4">
                                <div class="contact-info-icon me-3">
                                    <i class="bi bi-telephone-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-1">Phone</h5>
                                    <p class="text-muted small mb-0">+1 (555) 123-4567</p>
                                </div>
                            </div>

                            <!-- Office -->
                            <div class="d-flex mb-4">
                                <div class="contact-info-icon me-3">
                                    <i class="bi bi-geo-alt-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-1">Office</h5>
                                    <p class="text-muted small mb-0">123 Remote Lane, Innovation City, USA</p>
                                </div>
                            </div>

                            <!-- Support Hours -->
                            <div class="d-flex mb-4">
                                <div class="contact-info-icon me-3">
                                    <i class="bi bi-clock-fill"></i>
                                </div>
                                <div>
                                    <h5 class="fw-semibold mb-1">Support Hours</h5>
                                    <p class="text-muted small mb-0">Mon - Fri: 8:00am – 8:00pm UTC</p>
                                </div>
                            </div>

                            <!-- Social Links -->
                            <div class="mt-5 pt-3 border-top">
                                <h6 class="fw-semibold mb-3">Connect With Us</h6>
                                <div class="d-flex gap-2">
                                    <a href="#" class="btn btn-sm btn-light btn-icon rounded-circle" title="Facebook">
                                        <i class="bi bi-facebook text-primary"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light btn-icon rounded-circle" title="Twitter">
                                        <i class="bi bi-twitter text-primary"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light btn-icon rounded-circle" title="Instagram">
                                        <i class="bi bi-instagram text-primary"></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-light btn-icon rounded-circle" title="LinkedIn">
                                        <i class="bi bi-linkedin text-primary"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h2 class="h4 fw-bold text-primary mb-4">Send Us a Message</h2>

                            <form wire:submit.prevent="submitContactForm">
                                <!-- Name Field -->
                                <div class="mb-3">
                                    <label for="name" class="form-label fw-semibold">Your Name</label>
                                    <input type="text"
                                        id="name"
                                        wire:model="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter your name"
                                        required>
                                    @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Email Field -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">Your Email</label>
                                    <input type="email"
                                        id="email"
                                        wire:model="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="Enter your email"
                                        required>
                                    @error('email')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Subject Field -->
                                <div class="mb-3">
                                    <label for="subject" class="form-label fw-semibold">Subject</label>
                                    <input type="text"
                                        id="subject"
                                        wire:model="subject"
                                        class="form-control @error('subject') is-invalid @enderror"
                                        placeholder="What is this regarding?"
                                        required>
                                    @error('subject')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Message Field -->
                                <div class="mb-4">
                                    <label for="message" class="form-label fw-semibold">Message</label>
                                    <textarea
                                        id="message"
                                        wire:model="message"
                                        rows="5"
                                        class="form-control @error('message') is-invalid @enderror"
                                        placeholder="Type your message..."
                                        required></textarea>
                                    @error('message')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button type="submit"
                                    class="btn btn-primary btn-lg w-100"
                                    wire:loading.attr="disabled">
                                    <span wire:loading.class="d-none" wire:target="sendPasswordResetLink" class="d-inline-flex align-items-center justify-content-center">
                                        <i class="fas fa-paper-clip me-2"></i>
                                        Send Reset Link
                                    </span>
                                    <span wire:loading.class="d-inline-flex" wire:target="sendPasswordResetLink" class="align-items-center justify-content-center" style="display: none;">
                                        <i class="bi bi-arrow-repeat me-2"></i>
                                        Sending...
                                    </span>

                                    <span wire:loading.remove wire:target="submitContactForm">
                                        <i class="bi bi-send-fill me-2"></i>Send Message
                                    </span>
                                    <span wire:loading wire:target="submitContactForm">
                                        <span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>
                                        Sending...
                                    </span>
                                </button>

                                <!-- Success Message -->
                                @if (session('message'))
                                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                    <i class="bi bi-check-circle me-2"></i>
                                    {{ session('message') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif

                                <!-- Error Message -->
                                @if (session('error'))
                                <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                            </form>

                            <!-- Footer Text -->
                            <p class="text-muted text-center small mt-4">
                                <i class="bi bi-info-circle me-1"></i>
                                We aim to respond to all inquiries within 24 hours.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="h4 fw-bold mb-4 text-center">Find Us</h2>
            <div class="rounded-3 overflow-hidden shadow-sm" style="height: 400px;">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537363153169!3d-37.816279779751554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d43f1f1f1f1%3A0xf1f1f1f1f1f1f1f1!2sInnovation%20City!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus"
                    width="100%"
                    height="100%"
                    style="border:0;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    /* Hero Background Section */
    .contact-hero-bg {
        background: linear-gradient(135deg, #5b6ec7 0%, #7b68ee 100%);
        position: relative;
        overflow: hidden;
    }

    .contact-hero-bg::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1552664730-d307ca884978?auto=format&fit=crop&w=1500&q=80');
        background-size: cover;
        background-position: center;
        opacity: 0.15;
        z-index: 0;
    }

    .contact-hero-bg .row {
        position: relative;
        z-index: 1;
    }

    /* Contact Info Icon */
    .contact-info-icon {
        width: 56px;
        height: 56px;
        background: linear-gradient(135deg, #e8eef7 0%, #f0f4ff 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #5b6ec7;
        flex-shrink: 0;
    }

    /* Breadcrumb Light */
    .breadcrumb-light .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
    }

    .breadcrumb-light .breadcrumb-item a:hover {
        color: rgba(255, 255, 255, 1);
    }

    .breadcrumb-light .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.5);
    }

    /* Button Icon Style */
    .btn-icon {
        width: 40px;
        height: 40px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        background-color: #f0f4ff !important;
        transform: translateY(-2px);
    }

    /* Form Input Styling */
    .form-control {
        border: 1px solid #e0e0e0;
        padding: 0.625rem 0.875rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #5b6ec7;
        box-shadow: 0 0 0 0.2rem rgba(91, 110, 199, 0.1);
    }

    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.1);
    }

    /* Card Styling */
    .card {
        border-radius: 0.5rem;
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    /* Button Styling */
    .btn-primary {
        background-color: #5b6ec7;
        border-color: #5b6ec7;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #4a5ab0;
        border-color: #4a5ab0;
    }

    .btn-primary:focus {
        box-shadow: 0 0 0 0.25rem rgba(91, 110, 199, 0.25);
    }

    /* Text Primary */
    .text-primary {
        color: #5b6ec7 !important;
    }

    /* Gap utilities */
    .gap-2 {
        gap: 0.5rem;
    }

    .gap-4 {
        gap: 1rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .contact-hero-bg h1 {
            font-size: 2rem;
        }

        .display-5 {
            font-size: 2.5rem;
        }

        .contact-info-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
        }

        .btn-lg {
            padding: 0.5rem 1rem;
            font-size: 1rem;
        }
    }
</style>
@endpush