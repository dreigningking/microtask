<div>
    <!-- Success Message -->
    @if (session()->has('comment_success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('comment_success') }}
        </div>
    @endif

    <!-- Comments List -->
    @if($comments->count() > 0)
    <div class="space-y-6 mb-8">
        @foreach($comments as $comment)
        <div class="flex items-start gap-4">
            <img src="https://randomuser.me/api/portraits/{{ $comment->isByGuest() ? 'men' : 'women' }}/{{ $comment->user_id ?? rand(1, 99) }}.jpg" 
                 class="w-10 h-10 rounded-full object-cover" 
                 alt="{{ $comment->commenter_name }}">
            <div class="flex-1">
                <div class="font-semibold text-gray-800">
                    {{ $comment->commenter_name }} 
                    <span class="text-gray-400 text-xs ml-2">{{ $comment->time_ago }}</span>
                </div>
                <div class="text-gray-700 mt-1">{!! $comment->formatted_content !!}</div>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="text-center py-8 text-gray-500">
        <i class="ri-chat-1-line text-2xl mb-2"></i>
        <p>No comments yet. Be the first to comment!</p>
    </div>
    @endif

    <!-- Comment Form -->
    <form wire:submit.prevent="submitComment" class="bg-white rounded-lg shadow p-6 space-y-4">
        <div>
            <label for="comment" class="block text-gray-700 font-semibold mb-2">
                Add a Comment
                @if(!Auth::check())
                    <span class="text-sm font-normal text-gray-500">(Guest users can comment too)</span>
                @endif
            </label>
            <textarea 
                id="comment" 
                wire:model.defer="content"
                rows="4" 
                class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('content') border-red-500 @enderror" 
                placeholder="Write your comment..."></textarea>
            @error('content') 
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div> 
            @enderror
        </div>

        <!-- Guest User Fields -->
        @if($showGuestFields)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="guest_name" class="block text-gray-700 font-semibold mb-2">Your Name</label>
                <input 
                    type="text" 
                    id="guest_name"
                    wire:model.defer="guest_name"
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('guest_name') border-red-500 @enderror" 
                    placeholder="Enter your name">
                @error('guest_name') 
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div> 
                @enderror
            </div>
            <div>
                <label for="guest_email" class="block text-gray-700 font-semibold mb-2">Your Email</label>
                <input 
                    type="email" 
                    id="guest_email"
                    wire:model.defer="guest_email"
                    class="w-full px-4 py-3 rounded-button border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary @error('guest_email') border-red-500 @enderror" 
                    placeholder="Enter your email">
                @error('guest_email') 
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div> 
                @enderror
            </div>
        </div>
        @endif

        <div class="flex items-center justify-between">
            <button 
                type="submit" 
                class="bg-primary text-white px-8 py-3 rounded-button font-semibold shadow-md hover:bg-primary/90 transition"
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50">
                <span wire:loading.remove>Post Comment</span>
                <span wire:loading>Posting...</span>
            </button>
            
            @if(!Auth::check())
            <div class="text-sm text-gray-500">
                <a href="{{ route('login') }}" class="text-primary hover:underline">Login</a> to comment without moderation
            </div>
            @endif
        </div>
    </form>
</div> 