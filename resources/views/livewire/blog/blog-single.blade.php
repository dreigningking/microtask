<div>
    <!-- Featured Image -->
    <section class="bg-gray-50 py-10">
        <div class="container mx-auto px-4">
            <img src="https://picsum.photos/seed/featuredpost/1200/420" alt="Featured" class="blog-featured-img mx-auto mb-8">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl font-bold text-primary mb-4">How to Succeed as a Freelancer on Wonegig</h1>
                <div class="flex flex-wrap justify-center items-center text-gray-400 text-sm mb-4 gap-4">
                    <span><i class="ri-calendar-line mr-1"></i> {{ now()->format('M d, Y') }}</span>
                    <span><i class="ri-user-3-line mr-1"></i> Jane Doe</span>
                    <div class="blog-tags">
                        <span>Freelancing</span>
                        <span>Tips</span>
                        <span>Success</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Article Content -->
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto blog-article-content">
                <p>
                    Freelancing offers flexibility, independence, and the chance to work on projects you love. But how do you stand out and thrive on a platform like Wonegig?
                </p>
                <h2>1. Build a Standout Profile</h2>
                <p>
                    Your profile is your digital storefront. Use a professional photo, write a compelling bio, and showcase your best work. Highlight your skills and experience relevant to the gigs you want.
                </p>
                <h2>2. Apply Strategically</h2>
                <p>
                    Don’t just apply to every job. Read requirements carefully and tailor your proposal to show how you’ll solve the client’s problem. Quality beats quantity.
                </p>
                <h2>3. Communicate Clearly</h2>
                <p>
                    Respond promptly to messages, ask clarifying questions, and keep clients updated. Good communication builds trust and leads to repeat work.
                </p>
                <h2>4. Deliver Excellence</h2>
                <p>
                    Meet deadlines, follow instructions, and go the extra mile. Positive reviews and ratings will help you win more gigs.
                </p>
                <h2>5. Keep Learning</h2>
                <p>
                    The freelance world evolves fast. Take advantage of Wonegig’s resources, webinars, and community to keep your skills sharp.
                </p>
                <blockquote class="border-l-4 border-primary pl-4 italic text-gray-600 my-8">
                    “Success on Wonegig is about more than skills—it's about reliability, communication, and a passion for delivering value.”
                </blockquote>
                <p>
                    Ready to take your freelance career to the next level? <a href="{{ route('register') }}" class="text-primary underline">Join Wonegig today</a> and unlock new opportunities!
                </p>
            </div>
        </div>
    </section>

    <!-- Author Box -->
    <section class="py-8 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto flex items-center gap-6 bg-white rounded-lg shadow p-6">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Jane Doe" class="w-16 h-16 rounded-full object-cover border-2 border-primary">
                <div>
                    <h4 class="font-semibold text-lg mb-1">Jane Doe</h4>
                    <p class="text-gray-600 text-sm">Jane is a top-rated freelancer and community mentor on Wonegig, passionate about helping others succeed in the gig economy.</p>
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
                @foreach([1,2,3] as $i)
                <div class="bg-gray-50 rounded-lg shadow-md overflow-hidden flex flex-col">
                    <a href="{{ route('blog.show', $i) }}">
                        <img src="https://picsum.photos/seed/related{{ $i }}/400/250" alt="Related Blog" class="w-full h-40 object-cover">
                    </a>
                    <div class="p-4 flex-1 flex flex-col">
                        <a href="{{ route('blog.show', $i) }}">
                            <h4 class="font-semibold text-lg mb-2 text-primary hover:underline">Related Blog Post {{ $i }}</h4>
                        </a>
                        <span class="text-gray-400 text-xs"><i class="ri-calendar-line mr-1"></i> {{ now()->subDays($i+3)->format('M d, Y') }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Comments Section (Sample) -->
    <section class="py-12 bg-gray-50">
        <div class="container mx-auto px-4 max-w-3xl">
            <h3 class="text-xl font-bold text-primary mb-6">Comments</h3>
            <div class="space-y-6 mb-8">
                <div class="flex items-start gap-4">
                    <img src="https://randomuser.me/api/portraits/men/32.jpg" class="w-10 h-10 rounded-full object-cover" alt="User">
                    <div>
                        <div class="font-semibold text-gray-800">John Smith <span class="text-gray-400 text-xs ml-2">2 days ago</span></div>
                        <div class="text-gray-700">Great tips! I just landed my first gig on Wonegig thanks to this article.</div>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <img src="https://randomuser.me/api/portraits/women/65.jpg" class="w-10 h-10 rounded-full object-cover" alt="User">
                    <div>
                        <div class="font-semibold text-gray-800">Emily R. <span class="text-gray-400 text-xs ml-2">1 day ago</span></div>
                        <div class="text-gray-700">Very helpful. Looking forward to more content like this!</div>
                    </div>
                </div>
            </div>
            <form class="bg-white rounded-lg shadow p-6 space-y-4">
                <div>
                    <label for="comment" class="block text-gray-700 font-semibold mb-2">Add a Comment</label>
                    <textarea id="comment" rows="4" class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Write your comment..."></textarea>
                </div>
                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-button font-semibold shadow-md hover:bg-primary/90 transition">Post Comment</button>
            </form>
        </div>
    </section>
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