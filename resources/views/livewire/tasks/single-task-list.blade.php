<div>
    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
        <div class="flex justify-between items-start mb-3">
            <h2 class="text-xl font-semibold text-gray-800">{{ $task->title }}</h2>
            <div class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                {{ $task->user->country->currency_symbol ?? '$' }}{{ $task->budget_per_person }}
            </div>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-600 mb-3">
            <span class="flex items-center gap-1">
                <i class="ri-building-line"></i>
                <span>{{ $task->user->username }}</span>
            </span>
            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
            <span class="flex items-center gap-1">
                <i class="ri-task-line"></i>
                <span>{{ $task->template->name }}</span>
            </span>
            <span class="w-1 h-1 bg-gray-400 rounded-full"></span>
            <span class="flex items-center gap-1">
                <i class="ri-time-line"></i>
                <span>{{ $task->created_at->diffForHumans() }}</span>
            </span>
        </div>
        <p class="text-gray-600 mb-4 line-clamp-2">{{ $task->description }}</p>
        <div class="flex flex-wrap gap-2 mb-4">
            @if($task->platform)
            <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">{{ $task->platform->name }}</span>
            @endif
            <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-xs">
                @if($task->expected_completion_minutes < 60)
                    {{ $task->expected_completion_minutes }} mins
                @elseif($task->expected_completion_minutes < 1440)
                    {{ floor($task->expected_completion_minutes / 60) }} hrs
                @elseif($task->expected_completion_minutes < 10080)
                    {{ floor($task->expected_completion_minutes / 1440) }} days
                @elseif($task->expected_completion_minutes < 43200)
                    {{ floor($task->expected_completion_minutes / 10080) }} weeks
                @else
                    {{ floor($task->expected_completion_minutes / 43200) }} months
                @endif
            </span>
            @if($task->required_skills)
                @foreach(explode(',', $task->required_skills) as $skill)
                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-xs">{{ trim($skill) }}</span>
                @endforeach
            @endif
        </div>
        <button wire:click="showTaskDetails({{ $task->id }})" class="bg-primary text-white px-4 py-2 rounded-button hover:bg-primary/90 whitespace-nowrap">View Details</button>
    </div> 
</div>