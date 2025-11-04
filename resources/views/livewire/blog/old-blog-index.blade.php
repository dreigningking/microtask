<div>
    <!-- Hero Section -->
    <section class="blog-hero-bg">
        <div class="blog-hero-content text-center w-full">
            <h1 class="text-5xl font-bold text-white tracking-wide">Blog</h1>
        </div>
    </section>

    <!-- Blog Roll -->
    <section class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @forelse($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                    <a href="{{ route('blog.show', $post->slug) }}">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6 flex-1 flex flex-col">
                        <a href="{{ route('blog.show', $post->slug) }}">
                            <h2 class="text-xl font-semibold mb-2 text-primary hover:underline">{{ $post->title }}</h2>
                        </a>
                        <p class="text-gray-600 mb-4 flex-1">{{ Str::limit($post->excerpt, 120) }}</p>
                        <div class="flex items-center justify-between text-sm text-gray-400">
                            <span><i class="ri-calendar-line mr-1"></i> {{ $post->formatted_published_date }}</span>
                            <span><i class="ri-user-3-line mr-1"></i> {{ $post->author_name }}</span>
                        </div>
                        @if($post->tags)
                        <div class="mt-3 flex flex-wrap gap-1">
                            @foreach(array_slice($post->tags, 0, 3) as $tag)
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $tag }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-gray-500">
                        <i class="ri-article-line text-4xl mb-4"></i>
                        <h3 class="text-xl font-semibold mb-2">No blog posts yet</h3>
                        <p>Check back soon for the latest updates and tips!</p>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($posts->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $posts->links() }}
            </div>
            @endif
        </div>
    </section>
</div>
@push('styles')
<style>
    .blog-hero-bg {
        background: linear-gradient(135deg, #0f2447 0%, #0d47a1 100%);
        position: relative;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .blog-hero-bg::before {
        content: "";
        position: absolute;
        inset: 0;
        background-image: url('https://picsum.photos/seed/wonegigbloghero/1500/400');
        background-size: cover;
        background-position: center;
        opacity: 0.18;
        z-index: 0;
    }
    .blog-hero-content {
        position: relative;
        z-index: 1;
    }
</style>
@endpush