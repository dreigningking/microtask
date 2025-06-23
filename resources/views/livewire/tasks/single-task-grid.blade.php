<div class="job-card flex-shrink-0 w-80 snap-start bg-white rounded-lg shadow-md overflow-hidden">
    <div class="p-5">
        <div class="flex justify-between items-start mb-3">
            <div>
                <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs rounded-full mb-2">{{ $task->platform ?? 'Uncategorized' }}</span>
                <h3 class="font-semibold text-lg text-gray-800">{{ $task->title }}</h3>
            </div>
            <span class="text-lg font-bold text-primary">{{ $task->user->country->currency_symbol ?? '$' }}{{ $task->budget_per_person }}</span>
        </div>
        <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $task->description }}</p>
        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
            <div class="flex items-center">
                <div class="w-4 h-4 flex items-center justify-center mr-1">
                    <i class="ri-time-line"></i>
                </div>
                <span>{{ $task->estimated_time }}</span>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 flex items-center justify-center mr-1">
                    <i class="ri-user-line"></i>
                </div>
                <span>{{ $task->user->name ?? 'Anonymous' }}</span>
            </div>
        </div>
        <button class="w-full bg-primary text-white py-2 rounded-button font-medium hover:bg-primary/90 transition-colors whitespace-nowrap">View Details</button>
    </div>
</div>
