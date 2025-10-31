<div>
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="display-4 fw-bold mb-4">Earn Money from Small Tasks</h1>
                <p class="lead mb-4">Join thousands of users getting paid for completing simple micro-tasks. From social media activities, website surveys, game testing/trials etc... Find tasks that match your expertise.</p>
                <div class="d-flex gap-3 flex-wrap">
                    <a href="tasks.html" class="btn btn-light btn-lg">Find Tasks to Earn</a>
                    <a href="#" class="btn btn-outline-light btn-lg">Post a Task</a>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title center-title">How It Works</h2>
                <p class="text-muted">Simple steps to start earning or getting tasks done</p>
            </div>
            <div class="row g-4">
                <!-- For Workers -->
                <div class="col-lg-6">
                    <div class="how-it-works-card">
                        <div class="step-icon bg-primary">
                            <i class="bi bi-person-check"></i>
                        </div>
                        <h4 class="text-center mb-3">For Task Workers</h4>
                        <div class="d-flex mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">1</div>
                            <div class="ms-3">
                                <h6>Find Tasks</h6>
                                <p class="text-muted mb-0">Browse available tasks that match your skills</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">2</div>
                            <div class="ms-3">
                                <h6>Do & Submit</h6>
                                <p class="text-muted mb-0">Complete the task and submit your work</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">3</div>
                            <div class="ms-3">
                                <h6>Get Paid</h6>
                                <p class="text-muted mb-0">Receive payment after approval and review</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- For Posters -->
                <div class="col-lg-6">
                    <div class="how-it-works-card">
                        <div class="step-icon bg-success">
                            <i class="bi bi-briefcase"></i>
                        </div>
                        <h4 class="text-center mb-3">For Task Posters</h4>
                        <div class="d-flex mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">1</div>
                            <div class="ms-3">
                                <h6>Describe Task</h6>
                                <p class="text-muted mb-0">Post your task with clear requirements</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">2</div>
                            <div class="ms-3">
                                <h6>Receive Task Submissions</h6>
                                <p class="text-muted mb-0">Get notified when people do your task</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">3</div>
                            <div class="ms-3">
                                <h6>Review submissions</h6>
                                <p class="text-muted mb-0">Disburse pay only when you're satisfied with the work</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Categories -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title center-title">Popular Categories</h2>
                <p class="text-muted">Browse through the most in-demand categories and find the perfect task that matches your skills</p>
            </div>
            <div class="row g-4">
                
                @foreach($popularPlatforms as $platform)
                <div class="col-md-2 col-6">
                    <a href="#" class="category-card card text-center dont_decorate p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            @if($platform['image'])
                                <img src="{{ $platform['image'] }}" alt="{{ $platform['name'] }}" style="width:40px;height:40px;object-fit:contain;">
                            @else
                                <i class="bi bi-laptop text-primary fs-3"></i>
                            @endif
                        </div>
                        <h5>{{ $platform['name'] }}</h5>
                        <p class="text-muted small">{{ number_format($platform['jobs_count']) }} tasks available</p>
                    </a>
                </div>
                @endforeach
                
            </div>
        </div>
    </section>

    @if($tasks->count() > 0)
    <!-- Featured Tasks -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="section-title">Featured Tasks</h2>
                <a href="{{ route('explore') }}" class="btn btn-outline-primary">View All Tasks</a>
            </div>
            <div class="row g-4">
                @foreach($tasks as $task)
                <div class="col-lg-4 col-md-6">
                    @include('components.layouts.taskcard',['task'=> $task])
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
    <!-- Testimonials -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title center-title">What Our Users Say</h2>
                <p class="text-muted">Real stories from our community</p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body">
                            <p class="card-text">"I've earned over $2,000 completing micro-tasks in my spare time. It's perfect for students!"</p>
                            <div class="d-flex align-items-center">
                                <img src="https://placehold.co/50" alt="User" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Sarah Johnson</h6>
                                    <small class="text-muted">Completed 45 tasks</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body">
                            <p class="card-text">"As a small business owner, MicroTasker helped me get quality work done without hiring full-time."</p>
                            <div class="d-flex align-items-center">
                                <img src="https://placehold.co/50" alt="User" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Mike Chen</h6>
                                    <small class="text-muted">Posted 23 tasks</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-card card h-100">
                        <div class="card-body">
                            <p class="card-text">"The platform is easy to use and payments are always on time. Great for freelance beginners!"</p>
                            <div class="d-flex align-items-center">
                                <img src="https://placehold.co/50" alt="User" class="rounded-circle me-3">
                                <div>
                                    <h6 class="mb-0">Emily Rodriguez</h6>
                                    <small class="text-muted">Completed 32 tasks</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h3 class="mb-3">Ready to get started?</h3>
                    <p class="mb-0">Join thousands of users earning money or getting tasks done on MicroTasker.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="#" class="btn btn-light btn-lg me-2">Sign Up Now</a>
                    <a href="tasks.html" class="btn btn-outline-light btn-lg">Browse Tasks</a>
                </div>
            </div>
        </div>
    </section>

</div>