<div>
    <!-- Hero Section -->
    <section class="contact-hero-bg py-20">
        <div class="container mx-auto px-4 contact-hero-content text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-6">Contact Us</h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto mb-8">
                Have a question, need support, or want to partner with Wonegig? Our team is here to help you succeed.
            </p>
            <img src="https://images.unsplash.com/photo-1521737852567-6949f3f9f2b5?auto=format&fit=crop&w=800&q=80" alt="Contact Team" class="mx-auto rounded-lg shadow-lg w-full max-w-2xl border-4 border-white/30">
        </div>
    </section>

    <!-- Contact Info & Form Section -->
    <section class="py-16 px-8 bg-white">
        <div class="container mx-auto px-4 grid md:grid-cols-2 gap-12 items-start">
            <!-- Contact Info -->
            <div>
                <h2 class="text-2xl font-bold text-primary mb-6">Get in Touch</h2>
                <div class="flex items-start mb-6">
                    <div class="contact-info-icon">
                        <i class="ri-mail-send-line"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-1">Email</h4>
                        <p class="text-gray-700 text-sm">support@wonegig.com</p>
                    </div>
                </div>
                <div class="flex items-start mb-6">
                    <div class="contact-info-icon">
                        <i class="ri-phone-line"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-1">Phone</h4>
                        <p class="text-gray-700 text-sm">+1 (555) 123-4567</p>
                    </div>
                </div>
                <div class="flex items-start mb-6">
                    <div class="contact-info-icon">
                        <i class="ri-map-pin-line"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-1">Office</h4>
                        <p class="text-gray-700 text-sm">123 Remote Lane, Innovation City, USA</p>
                    </div>
                </div>
                <div class="flex items-start mb-6">
                    <div class="contact-info-icon">
                        <i class="ri-time-line"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-1">Support Hours</h4>
                        <p class="text-gray-700 text-sm">Mon - Fri: 8:00am – 8:00pm UTC</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 mt-8">
                    <a href="#" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30">
                        <i class="ri-facebook-fill text-primary"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30">
                        <i class="ri-twitter-fill text-primary"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30">
                        <i class="ri-instagram-fill text-primary"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30">
                        <i class="ri-linkedin-fill text-primary"></i>
                    </a>
                </div>
            </div>
            <!-- Contact Form -->
            <div>
                <h2 class="text-2xl font-bold text-primary mb-6">Send Us a Message</h2>
                <form wire:submit.prevent="submitContactForm" class="bg-gray-50 rounded-lg shadow-lg p-8 space-y-6">
                    <div>
                        <label for="name" class="block text-gray-700 font-semibold mb-2">Your Name</label>
                        <input type="text" id="name" name="name" wire:model.defer="name" class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your name" required>
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-gray-700 font-semibold mb-2">Your Email</label>
                        <input type="email" id="email" name="email" wire:model.defer="email" class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Enter your email" required>
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="subject" class="block text-gray-700 font-semibold mb-2">Subject</label>
                        <input type="text" id="subject" name="subject" wire:model.defer="subject" class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Subject" required>
                        @error('subject') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="message" class="block text-gray-700 font-semibold mb-2">Message</label>
                        <textarea id="message" name="message" rows="5" wire:model.defer="message" class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Type your message..." required></textarea>
                        @error('message') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <button type="submit" class="bg-primary text-white px-8 py-3 rounded-button font-semibold shadow-md hover:bg-primary/90 transition" wire:loading.attr="disabled">
                        <span wire:loading.remove>Send Message</span>
                        <span wire:loading>Sending...</span>
                    </button>
                </form>
                @if (session('message'))
                    <div class="mt-4 text-green-600 text-sm font-semibold">{{ session('message') }}</div>
                @endif
                @if (session('error'))
                    <div class="mt-4 text-red-600 text-sm font-semibold">{{ session('error') }}</div>
                @endif
                <p class="text-gray-500 text-xs mt-4">We aim to respond to all inquiries within 24 hours.</p>
            </div>
        </div>
    </section>

    <!-- Map Section (Optional) -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="rounded-lg overflow-hidden shadow-lg">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.835434509374!2d144.9537363153169!3d-37.816279779751554!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d43f1f1f1f1%3A0xf1f1f1f1f1f1f1f1!2sInnovation%20City!5e0!3m2!1sen!2sus!4v1620000000000!5m2!1sen!2sus"
                    width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
    .contact-hero-bg {
        background: linear-gradient(135deg, #0f2447 0%, #0d47a1 100%);
        position: relative;
        overflow: hidden;
    }
    .contact-hero-bg::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=1500&q=80');
        background-size: cover;
        background-position: center;
        opacity: 0.18;
        z-index: 0;
    }
    .contact-hero-content {
        position: relative;
        z-index: 1;
    }
    .contact-info-icon {
        width: 48px;
        height: 48px;
        background: #e3eafe;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #1e3a8a;
        margin-right: 1rem;
    }
</style>
@endpush
