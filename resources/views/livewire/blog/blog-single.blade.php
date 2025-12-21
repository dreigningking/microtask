<div>

    <section class="jumbo-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <span class="blog-category">{{ $post->category->name }}</span>
                    <h1 class="display-5 fw-bold my-3">{{ $post->title }}</h1>
                    <p class="lead mb-4">{{ $post->excerpt }}</p>
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{ $post->user->avatar ?? 'https://placehold.co/60x60/667eea/ffffff?text=' . substr($post->user->name, 0, 2) }}" alt="Author" class="author-avatar me-3">
                        <div class="text-start">
                            <div class="fw-bold">{{ $post->user->name }}</div>
                            <div class="text-white-50">{{ $post->created_at->format('M j, Y') }} · {{ $post->reading_time }} min read</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Content -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="blog-content">
                        @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" class="img-fluid w-100" alt="Blog Post Image">
                        @else
                        <img src="https://placehold.co/800x400/667eea/ffffff?text=Blog+Post+Image" class="img-fluid w-100" alt="Blog Post Image">
                        @endif

                        {!! $post->content !!}
                    </div>

                    <!-- Share & Tags -->
                    <div class="d-flex justify-content-between align-items-center mt-5 py-4 border-top border-bottom">
                        <div class="share-buttons">
                            <span class="fw-bold me-2">Share this post:</span>
                            <button class="btn btn-outline-primary btn-sm"><i class="bi bi-twitter"></i> Twitter</button>
                            <button class="btn btn-outline-primary btn-sm"><i class="bi bi-facebook"></i> Facebook</button>
                            <button class="btn btn-outline-primary btn-sm"><i class="bi bi-linkedin"></i> LinkedIn</button>
                            <button class="btn btn-outline-primary btn-sm"><i class="bi bi-link-45deg"></i> Copy Link</button>
                        </div>
                        <div>
                            @if($post->tags)
                            @foreach($post->tags as $tag)
                            <span class="badge bg-light text-dark me-1">#{{ $tag }}</span>
                            @endforeach
                            @endif
                        </div>
                    </div>

                    <!-- Author Bio 
                <div class="author-card card mt-5">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center">
                                <img src="https://placehold.co/120x120/667eea/ffffff?text=SJ" alt="Author" class="author-avatar mb-3">
                            </div>
                            <div class="col-md-9">
                                <h4>Sarah Johnson</h4>
                                <p class="text-muted">Professional graphic designer and top earner on MicroTasker. Sarah has completed over 200 tasks with a 4.9-star rating and specializes in brand identity and social media graphics.</p>
                                <div class="d-flex">
                                    <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="btn btn-outline-primary btn-sm me-2"><i class="bi bi-linkedin"></i></a>
                                    <a href="#" class="btn btn-outline-primary btn-sm"><i class="bi bi-globe"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->

                    <!-- Comments Section -->
                    <div class="mt-5" id="comments-section">
                        <h3 class="section-title">Comments ({{ $comments->count() }})</h3>

                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <!-- Reply Indicator -->
                        @if($parentId)
                        <div class="alert alert-info">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Replying to <strong>{{ $comments->where('id', $parentId)->first()->user->name }}</strong></span>
                                <button type="button" class="btn-close" wire:click="$set('parentId', null)"></button>
                            </div>
                        </div>
                        @endif

                        <!-- Comments List -->
                        <div class="mb-4">
                            @foreach($comments->whereNull('parent_id') as $comment)
                            <div class="d-flex mb-4">
                                <img src="{{ $comment->user->avatar ?? 'https://placehold.co/50x50/10b981/ffffff?text=' . substr($comment->user->name, 0, 2) }}" alt="Commenter" class="comment-avatar me-3">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-2">{{ $comment->body }}</p>
                                    <button class="btn btn-outline-primary btn-sm" wire:click="setReply({{ $comment->id }})">Reply</button>
                                    @if($comment->children)
                                    @foreach($comment->children as $reply)
                                    <div class="d-flex mt-3 ms-4">
                                        <img src="{{ $reply->user->avatar ?? 'https://placehold.co/40x40/f59e0b/ffffff?text=' . substr($reply->user->name, 0, 2) }}" alt="Commenter" class="comment-avatar me-3" style="width: 30px; height: 30px;">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="mb-0">{{ $reply->user->name }}</h6>
                                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-2">{{ $reply->body }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Comment Form -->
                        @if(Auth::check())
                        <form wire:submit="submitComment">
                            <h5 class="mb-3">Leave a Comment</h5>
                            <div class="mb-3">
                                <textarea class="form-control" wire:model="commentBody" rows="4" placeholder="Share your thoughts..."></textarea>
                                @error('commentBody') <div class="text-danger">{{ $message }}</div> @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">All comments are moderated before being published</small>
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </div>
                        </form>
                        @else
                        <p>Please <a href="{{ route('login') }}">login</a> to comment.</p>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Popular Posts -->
                    <div class="sidebar-card card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Popular Posts</h5>

                            @foreach($popularPosts as $popularPost)
                            <div class="popular-post">
                                <img src="{{ $popularPost->featured_image ?? 'https://placehold.co/80x60/667eea/ffffff?text=Popular' }}" alt="Popular Post" class="popular-post-image">
                                <div>
                                    <h6 class="mb-1"><a href="{{ route('blog.show', $popularPost) }}" class="text-decoration-none">{{ $popularPost->title }}</a></h6>
                                    <small class="text-muted">{{ $popularPost->created_at->format('M j, Y') }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="sidebar-card card mb-4" id="categories">
                        <div class="card-body">
                            <h5 class="card-title">Categories</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <a href="{{ route('blog') }}" class="text-decoration-none d-flex justify-content-between align-items-center">
                                        <span>All Categories</span>
                                        <span class="badge bg-primary">{{ $categories->sum(fn($cat) => $cat->posts()->published()->count()) }}</span>
                                    </a>
                                </li>
                                @foreach($categories as $cat)
                                <li class="mb-2">
                                    <a href="{{ route('blog') }}?category={{ $cat->slug }}" class="text-decoration-none d-flex justify-content-between align-items-center">
                                        <span>{{ $cat->name }}</span>
                                        <span class="badge bg-primary">{{ $cat->posts()->published()->count() }}</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Newsletter 
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
                </div>
                -->
                </div>
            </div>
        </div>
    </section>

</div>