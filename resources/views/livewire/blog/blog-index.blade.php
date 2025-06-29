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
                @foreach(range(1,8) as $i)
                <div class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col">
                    <a href="{{ route('blog.show', $i) }}">
                        <img src="https://picsum.photos/seed/{{ $i }}wonegig/400/250" alt="Blog Image" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-6 flex-1 flex flex-col">
                        <a href="{{ route('blog.show', $i) }}">
                            <h2 class="text-xl font-semibold mb-2 text-primary hover:underline">Sample Blog Post Title {{ $i }}</h2>
                        </a>
                        <p class="text-gray-600 mb-4 flex-1">This is a short excerpt from the blog post. Discover tips, stories, and platform updates to help you succeed on Wonegig.</p>
                        <div class="flex items-center justify-between text-sm text-gray-400">
                            <span><i class="ri-calendar-line mr-1"></i> {{ now()->subDays($i)->format('M d, Y') }}</span>
                            <span><i class="ri-user-3-line mr-1"></i> Admin</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <nav class="inline-flex rounded-md shadow-sm" aria-label="Pagination">
                    <a href="#" class="px-4 py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-l-md">Previous</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-primary font-semibold">1</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">2</a>
                    <a href="#" class="px-4 py-2 border-t border-b border-gray-300 bg-white text-gray-500 hover:bg-gray-50">3</a>
                    <a href="#" class="px-4 py-2 border border-gray-300 bg-white text-gray-500 hover:bg-gray-50 rounded-r-md">Next</a>
                </nav>
            </div>
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