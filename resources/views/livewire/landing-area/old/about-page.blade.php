<div>
    <!-- Hero Section -->
    <section class="hero-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold text-white mb-4">Your Gateway to Flexible Work</h1>
                    <p class="lead text-white-50 mb-4">
                        Wonegig is where skilled professionals meet meaningful opportunities. Whether you're looking for quick micro-tasks or long-term projects, we've got you covered.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Get Started Free</a>
                        <a href="{{ route('explore') }}" class="btn btn-outline-light btn-lg">Browse Jobs</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80" class="img-fluid rounded-4 shadow-lg" alt="Team Collaboration">
                </div>
            </div>
        </div>
    </section>

    <!-- What You Can Do -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">What You Can Do on Wonegig</h2>
                    <p class="text-muted">Discover endless possibilities to earn and grow</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h4>Quick Micro-Tasks</h4>
                        <p>Complete small tasks in minutes and earn instantly. Perfect for those looking to make extra income in their spare time.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Graphic design tasks</li>
                            <li><i class="fas fa-check text-success me-2"></i>Content writing</li>
                            <li><i class="fas fa-check text-success me-2"></i>Data entry</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h4>Long-term Projects</h4>
                        <p>Build lasting relationships with clients through comprehensive project work. Ideal for professionals seeking stable income.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Web development</li>
                            <li><i class="fas fa-check text-success me-2"></i>Mobile app creation</li>
                            <li><i class="fas fa-check text-success me-2"></i>Consulting services</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h4>Work from Anywhere</h4>
                        <p>Our platform connects you with opportunities worldwide. Work remotely and choose your own schedule.</p>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-check text-success me-2"></i>Remote work options</li>
                            <li><i class="fas fa-check text-success me-2"></i>Flexible scheduling</li>
                            <li><i class="fas fa-check text-success me-2"></i>Global opportunities</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Wonegig -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Why Choose Wonegig</h2>
                    <p class="text-muted">We're built differently to serve you better</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>Secure Payments</h4>
                            <p>Your earnings are protected with escrow-backed payments. Funds are locked on project start and auto-released on approval.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>Transparent Fees</h4>
                            <p>Simple 10% freelancer fee with no hidden charges. Keep more of what you earn with our straightforward pricing.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>AI-Powered Matching</h4>
                            <p>Our intelligent algorithm connects you with the best opportunities based on your skills, experience, and preferences.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-headset"></i>
                        </div>
                        <div class="benefit-content">
                            <h4>24/7 Support</h4>
                            <p>Get help whenever you need it. Our support team is available around the clock to assist with any questions.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 cta-section" style="color:white !important">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="mb-4">Ready to Start Your Journey?</h2>
                    <p class="lead mb-4">Join thousands of professionals who are already earning on Wonegig</p>
                    <div class="d-flex gap-3 justify-content-center">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Create Free Account</a>
                        <a href="{{ route('explore') }}" class="btn btn-outline-light btn-lg">Browse Opportunities</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Success Stories -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Success Stories</h2>
                    <p class="text-muted">Real people, real results</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"Wonegig helped me transition from a 9-5 job to full-time freelancing. The platform is intuitive and the support is amazing."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sarah M." class="testimonial-avatar">
                            <div>
                                <h5>Sarah M.</h5>
                                <span class="text-muted">Web Developer</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"I love the variety of tasks available. From quick micro-jobs to complex projects, there's always something that fits my schedule."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="David K." class="testimonial-avatar">
                            <div>
                                <h5>David K.</h5>
                                <span class="text-muted">Graphic Designer</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <div class="testimonial-content">
                            <p>"The payment system is reliable and the fees are transparent. I've been earning consistently for over a year now."</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Maria L." class="testimonial-avatar">
                            <div>
                                <h5>Maria L.</h5>
                                <span class="text-muted">Content Writer</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.cta-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    /* position: relative; */
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.feature-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 2rem rgba(0,0,0,0.15);
}

.feature-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.feature-icon i {
    font-size: 1.5rem;
    color: white;
}

.benefit-card {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 0.25rem 0.5rem rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.benefit-card:hover {
    transform: translateY(-3px);
}

.benefit-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.benefit-icon i {
    font-size: 1.25rem;
    color: white;
}

.benefit-content h4 {
    margin-bottom: 0.5rem;
    color: #333;
}

.testimonial-card {
    background: white;
    border-radius: 1rem;
    padding: 2rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    height: 100%;
}

.testimonial-card:hover {
    transform: translateY(-3px);
}

.testimonial-content {
    margin-bottom: 1.5rem;
}

.testimonial-content p {
    font-style: italic;
    color: #666;
    line-height: 1.6;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.testimonial-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
}

.testimonial-author h5 {
    margin: 0;
    font-size: 1rem;
    color: #333;
}

.testimonial-author span {
    font-size: 0.875rem;
}

/* Animation for cards */
.feature-card, .benefit-card, .testimonial-card {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }
    
    .hero-section {
        text-align: center;
    }
    
    .benefit-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endpush