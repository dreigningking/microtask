<div>
    <!-- Resources Page Hero -->
    <section class="page-hero" id="resources">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="hero-title">Wonegig Resources</h1>
                    <p class="hero-subtitle">Browse through our resources to master the Wongig platform and stay updated with the latest news and trends.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="#newsletter" class="btn btn-outline-light btn-lg">Subscribe to Newsletter</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Resource Categories -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h2 class="section-title">Resource Categories</h2>
                    <p class="text-muted">Explore our content by category</p>
                </div>
            </div>

            <div class="row">
                @foreach ($categories as $category)
                <div class="col-md-4">
                    <div class="post-category-card">
                        <a class="text-decoration-none" href="{{ route('blog', ['category' => $category]) }}">
                            <div>
                                <h5>{{ $category }}</h5>
                                <p class="text-muted mb-0">Explore articles and resources related to {{ $category }}</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach

                
            </div>
        </div>
    </section>

    <!-- Resources Tabs -->
    <section class="py-5 bg-light">
        <div class="container">
            

            <div class="row">
                @forelse ($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="resource-card">
                        <img src="{{ Storage::url($post->featured_image) }}" class="img-fluid resource-img" alt="{{ $post->title }}">
                        <div class="resource-body">
                            <span class="resource-category">{{ $post->category ?? 'Uncategorized' }}</span>
                            <h4>{{ $post->title }}</h4>
                            <p class="text-muted">{{ Str::limit($post->excerpt, 100) }}</p>
                            <a href="{{ route('blog.show', $post) }}" class="btn btn-link p-0">Read More <i class="fas fa-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center">
                    <p class="text-muted">No posts found.</p>
                    @if(request()->has('category') && request()->get('category'))
                        <a href="{{ route('blog') }}" class="btn btn-outline-primary mt-3">View All Posts</a>
                    @endif
                </div>
                @endforelse
            </div>
            <div class="mt-3">
                {{ $posts->links() }}
            </div>
        </div>
    </section>

    

    <!-- Newsletter Section -->
    <section class="py-5" id="newsletter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <div class="feature-icon mx-auto">
                        <i class="fas fa-envelope-open-text"></i>
                    </div>
                    <h2>Get articles Delivered to Your Inbox</h2>
                    <p class="text-muted mb-4">Subscribe to our newsletter for the latest articles, news, and updates.</p>

                    <div class="row justify-content-center">
                        <div class="col-lg-8">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control form-control-lg" placeholder="Your email address">
                                <button class="btn btn-primary btn-lg" type="button">Subscribe</button>
                            </div>
                            <p class="text-muted small">We respect your privacy. Unsubscribe at any time.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>