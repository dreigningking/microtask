<div>
    <!-- Featured Image -->
    <section class="bg-gray-50 py-10">
        <div class="container mx-auto px-4">
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="blog-featured-img mx-auto mb-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-bold text-primary mb-4">{{ $post->title }}</h1>
                <div class="flex flex-wrap justify-center items-center text-gray-400 text-sm mb-4 gap-4">
                    <span><i class="ri-calendar-line mr-1"></i> {{ $post->formatted_published_date }}</span>
                    <span><i class="ri-user-3-line mr-1"></i> {{ $post->author_name }}</span>
                    @if($post->reading_time)
                    <span><i class="ri-time-line mr-1"></i> {{ $post->reading_time }} min read</span>
                    @endif
                    @if($post->tags)
                    <div class="blog-tags">
                        @foreach($post->tags as $tag)
                        <span>{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto blog-article-content">
                {!! $post->content !!}
            </div>
        </div>
    </section>

    <!-- Author Box -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto flex items-center gap-6 bg-white rounded-lg shadow p-6">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="{{ $post->author_name }}" class="w-16 h-16 rounded-full object-cover border-2 border-primary">
                <div>
                    <h4 class="font-semibold text-lg mb-1">{{ $post->author_name }}</h4>
                    <p class="text-gray-600 text-sm">Author of this blog post on Wonegig.</p>
                    <div class="flex space-x-2 mt-2">
                        <a href="#" class="text-primary hover:underline"><i class="ri-twitter-fill"></i></a>
                        <a href="#" class="text-primary hover:underline"><i class="ri-linkedin-fill"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Posts -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <h3 class="text-2xl font-bold text-primary mb-8">Related Posts</h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @php
                    $relatedPosts = \App\Models\Post::published()
                        ->where('id', '!=', $post->id)
                        ->where('status', 'published')
                        ->orderBy('published_at', 'desc')
                        ->limit(3)
                        ->get();
                @endphp
                
                @forelse($relatedPosts as $relatedPost)
                <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden flex flex-col">
                    <a href="{{ route('blog.show', $relatedPost->slug) }}">
                        <img src="{{ $relatedPost->featured_image_url }}" alt="{{ $relatedPost->title }}" class="w-full h-40 object-cover">
                    </a>
                    <div class="p-4 flex-1 flex flex-col">
                        <a href="{{ route('blog.show', $relatedPost->slug) }}">
                            <h4 class="font-semibold text-lg mb-2 text-primary hover:underline">{{ $relatedPost->title }}</h4>
                        </a>
                        <span class="text-gray-400 text-xs"><i class="ri-calendar-line mr-1"></i> {{ $relatedPost->formatted_published_date }}</span>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-8">
                    <p class="text-gray-500">No related posts found.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Comments Section -->
    @if($post->allow_comments)
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <h3 class="text-xl font-bold text-primary mb-6">Comments ({{ $post->comments_count }})</h3>
            
            @livewire('dashboard-area.blog.blog-comments', ['post' => $post])
        </div>
    </section>
    @endif
</div>
@push('styles')
<style>
    .blog-featured-img {
        max-height: 420px;
        object-fit: cover;
        width: 100%;
        border-radius: 1rem;
        box-shadow: 0 8px 32px rgba(16, 42, 67, 0.12);
    }
    .blog-article-content h2 {
        font-size: 1.5rem;
        font-weight: 700;
        margin-top: 2rem;
        margin-bottom: 1rem;
    }
    .blog-article-content p {
        margin-bottom: 1.25rem;
        line-height: 1.8;
    }
    .blog-tags span {
        background: #e3eafe;
        color: #1e3a8a;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
        margin-right: 0.5rem;
    }
</style>
@endpush
