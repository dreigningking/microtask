<div>
    <!-- Resources Page Hero -->
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Wonegig Resources</h1>
                    <p class="lead mb-4">Browse through our resources to master the Wongig platform and stay updated with the latest news and trends.</p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#featured" class="btn btn-light">Featured Posts</a>
                        <a href="#categories" class="btn btn-outline-light">Browse Categories</a>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-journal-text display-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <!-- Featured Posts -->
                    @if($featuredPosts->count() > 0)
                    <div class="mb-5" id="featured">
                        <h2 class="section-title">Featured Posts</h2>
                        <div class="row">
                            @foreach($featuredPosts as $post)
                            <div class="col-md-6 mb-4">
                                <div class="blog-card card h-100">
                                    <img src="{{ $post->featured_image ?: 'https://placehold.co/600x400/667eea/ffffff?text=Blog' }}" class="blog-image" alt="{{ $post->title }}">
                                    <div class="card-body">
                                        <span class="blog-category">{{ $post->category->name }}</span>
                                        <h4 class="card-title mt-2"><a href="{{ route('blog.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a></h4>
                                        <p class="card-text text-muted">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 100) }} <a href="{{ route('blog.show', $post) }}" class="text-primary">Read More</a></p>
                                        <div class="d-flex align-items-center mt-3">
                                            <img src="{{ $post->user->image ?? 'https://placehold.co/40x40/667eea/ffffff?text=' . substr($post->user->name, 0, 2) }}" alt="Author" class="comment-avatar me-2">
                                            <div>
                                                <div class="fw-bold">{{ $post->user->name }}</div>
                                                <div class="read-time">{{ $post->created_at->format('M d, Y') }} · {{ $post->reading_time ?? 5 }} min read</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Recent Posts -->
                    <div class="mb-5">
                        <h2 class="section-title">Recent Posts</h2>

                        @forelse($posts as $post)
                        <div class="blog-card card mb-4">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ $post->featured_image ?: 'https://placehold.co/400x300/3b82f6/ffffff?text=Blog' }}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="{{ $post->title }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <span class="blog-category">{{ $post->category->name }}</span>
                                        <h4 class="card-title"><a href="{{ route('blog.show', $post) }}" class="text-decoration-none">{{ $post->title }}</a></h4>
                                        <p class="card-text text-muted">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }} <a href="{{ route('blog.show', $post) }}" class="text-primary">Read More</a></p>
                                        <div class="d-flex align-items-center mt-3">
                                            <img src="{{ $post->user->image ?? 'https://placehold.co/40x40/3b82f6/ffffff?text=' . substr($post->user->name, 0, 2) }}" alt="Author" class="comment-avatar me-2">
                                            <div>
                                                <div class="fw-bold">{{ $post->user->name }}</div>
                                                <div class="read-time">{{ $post->created_at->format('M d, Y') }} · {{ $post->reading_time ?? 5 }} min read</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-journal-text display-4 text-muted mb-3"></i>
                            <h5 class="text-muted">No posts found</h5>
                            <p class="text-muted">Try adjusting your search or category filter.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($posts->hasPages())
                    <nav aria-label="Blog pagination">
                        {{ $posts->links() }}
                    </nav>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Search -->
                    <div class="sidebar-card card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Search Blog</h5>
                            <div class="input-group">
                                <input type="text" wire:model.live="search" class="form-control" placeholder="Search articles...">
                                <button class="btn btn-primary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-card card mb-4" id="categories">
                        <div class="card-body">
                            <h5 class="card-title">Categories</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <a href="{{ route('blog') }}" class="text-decoration-none d-flex justify-content-between align-items-center {{ !$category ? 'fw-bold text-primary' : '' }}">
                                        <span>All Categories</span>
                                        <span class="badge bg-primary">{{ $categories->sum(fn($cat) => $cat->posts()->published()->count()) }}</span>
                                    </a>
                                </li>
                                @foreach($categories as $cat)
                                <li class="mb-2">
                                    <a href="{{ route('blog') }}?category={{ $cat->slug }}" class="text-decoration-none d-flex justify-content-between align-items-center {{ $category == $cat->slug ? 'fw-bold text-primary' : '' }}">
                                        <span>{{ $cat->name }}</span>
                                        <span class="badge bg-primary">{{ $cat->posts()->published()->count() }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Popular Posts -->
                    <div class="sidebar-card card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Popular Posts</h5>

                            <div class="popular-post">
                                <img src="https://placehold.co/80x60/667eea/ffffff?text=Popular" alt="Popular Post" class="popular-post-image">
                                <div>
                                    <h6 class="mb-1">How to Maximize Your Earnings on MicroTasker</h6>
                                    <small class="text-muted">Oct 28, 2023</small>
                                </div>
                            </div>

                            <div class="popular-post">
                                <img src="https://placehold.co/80x60/10b981/ffffff?text=Popular" alt="Popular Post" class="popular-post-image">
                                <div>
                                    <h6 class="mb-1">The Complete Guide to Task Applications</h6>
                                    <small class="text-muted">Oct 22, 2023</small>
                                </div>
                            </div>

                            <div class="popular-post">
                                <img src="https://placehold.co/80x60/f59e0b/ffffff?text=Popular" alt="Popular Post" class="popular-post-image">
                                <div>
                                    <h6 class="mb-1">5 Common Mistakes New Task Posters Make</h6>
                                    <small class="text-muted">Oct 15, 2023</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags 
                    <div class="sidebar-card card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Popular Tags</h5>
                            <div class="d-flex flex-wrap">
                                <a href="#" class="blog-tag">Earnings</a>
                                <a href="#" class="blog-tag">Tips</a>
                                <a href="#" class="blog-tag">Success</a>
                                <a href="#" class="blog-tag">Freelancing</a>
                                <a href="#" class="blog-tag">Applications</a>
                                <a href="#" class="blog-tag">Productivity</a>
                                <a href="#" class="blog-tag">Reviews</a>
                                <a href="#" class="blog-tag">Community</a>
                            </div>
                        </div>
                    </div>

                    Newsletter 
                    <div class="sidebar-card card">
                        <div class="card-body">
                            <h5 class="card-title">Subscribe to Newsletter</h5>
                            <p class="card-text text-muted small">Get the latest blog posts and platform updates delivered to your inbox.</p>
                            <div class="input-group mb-2">
                                <input type="email" class="form-control" placeholder="Your email address">
                                <button class="btn btn-primary" type="button">Subscribe</button>
                            </div>
                            <small class="text-muted">We respect your privacy. Unsubscribe at any time.</small>
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </section>
</div>