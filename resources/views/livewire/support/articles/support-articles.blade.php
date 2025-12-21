<div>
    <!-- Support Articles Page Hero -->
    <section class="task-header py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Support Articles</h1>
                    <p class="lead mb-4">Find answers to your questions with our comprehensive help articles and guides.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <i class="bi bi-question-circle display-1 opacity-75"></i>
                </div>
            </div>
        </div>
    </section>

    <!-- Support Articles Content -->
    <section class="py-5">
        <div class="container">
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">


                    <!-- Recent Articles -->
                    <div class="mb-5">
                        <h2 class="section-title">Help Articles</h2>
                        <div class="card my-4">
                            <div class="card-body">
                                
                                <div class="input-group">
                                    <input type="text" wire:model.live="search" class="form-control" placeholder="Search help articles...">
                                    <button class="btn btn-primary" type="button">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @forelse($posts as $post)
                        <div class="blog-card card mb-4">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ $post->featured_image ?: 'https://placehold.co/400x300/10b981/ffffff?text=Support' }}" class="img-fluid h-100 w-100" style="object-fit: cover;" alt="{{ $post->title }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <span class="blog-category">{{ $post->category->name }}</span>
                                        <h4 class="card-title"><a href="{{ route('support.articles.post', $post) }}" class="text-decoration-none">{{ $post->title }}</a></h4>
                                        <p class="card-text text-muted">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }} <a href="{{ route('support.articles.post', $post) }}" class="text-primary">Read More</a></p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-question-circle display-4 text-muted mb-3"></i>
                            <h5 class="text-muted">No articles found</h5>
                            <p class="text-muted">Try adjusting your search or category filter.</p>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($posts->hasPages())
                    <nav aria-label="Support articles pagination">
                        {{ $posts->links() }}
                    </nav>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
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


                    <!-- Contact Support -->
                    <div class="sidebar-card card">
                        <div class="card-body">
                            <h5 class="card-title">Still Need Help?</h5>
                            <p class="card-text text-muted small">Can't find what you're looking for? Contact our support team.</p>
                            <a href="{{ route('support') }}" class="btn btn-primary w-100">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>